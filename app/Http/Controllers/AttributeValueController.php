<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::all();
        return view('attribute_values.index', compact('attributeValues'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('attribute_values.create',compact('attributes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'value' => 'required|string|unique:attribute_values,value',
            'attribute_id' => 'required|exists:attributes,id',
        ]);

        AttributeValue::create($data);

        return redirect()->route('attribute_values.index');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $data = $request->validate([
            'value' => 'required|string',
            'attribute_id' => 'required|exists:attributes,id',
            'type' => 'required|in:range,select',
            'range_values' => 'nullable|string',
            'select_values' => 'nullable|array',
            'select_values.*' => 'exists:attribute_values,id',
        ]);

        $attributeValue->update([
            'value' => $data['value'],
            'attribute_id' => $data['attribute_id'],
            'range_values' => $data['range_values'],
            'select_values' => $data['select_values'] ?? [],
        ]);

        return redirect()->route('attribute_values.index');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return redirect()->route('attribute_values.index');
    }
}
