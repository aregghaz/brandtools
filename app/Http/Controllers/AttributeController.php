<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->get();
        return response()->json(new AttributeCollection($attributes));
    }

    public function show(Attribute $attribute)
    {
        $data = [
            (object)[
                "id" => 1,
                "title" => "select",
                "label" => "select",
                "name" => "select",
                "value" => 1
            ],
            (object)[
                "id" => 2,
                "title" => "range",
                "label" => "range",
                "name" => "range",
                "value" => 2
            ]
        ];
        $keys = array_column($data, 'id');
        $index = array_search((int)$attribute->type, $keys);
        return response()->json([
            "data" => [
                "id" => $attribute->id,
                "title" => $attribute->title,
                "type" => $data[$index],
                "updated_at" => $attribute->updated_at,

            ],
            "type" => new SelectCollection($data)
        ]);
    }

    public function create()
    {
        $data = [
            (object)[
                "id" => 1,
                "title" => "select"
            ],
            (object)[
                "id" => 2,
                "title" => "range"
            ]
        ];
        return response()->json(["types" => new SelectCollection($data)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $attributes = Attribute::create([
            "title" => $data->title,
            "type" => $data->types->id
        ]);

        return response()->json($attributes);
    }

    public function edit(Attribute $attribute)
    {
        return view('attributes.edit', compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $attribute->update([
            "title" => $data->title,
            "type" => $data->type->id
        ]);

        return response()->json([
            'attribute' => $attribute,
            'status' => 200
        ]);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json([
            "status" => 200,
        ]);
    }
}
