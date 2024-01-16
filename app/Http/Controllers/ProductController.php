<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('products.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required',
        ]);

        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $product->categories()->sync($data['categories']);

        foreach ($data['attributes'] as $attribute) {
            $product->attributes()->attach($attribute['id'], ['value' => $attribute['value']]);
        }

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('products.edit', compact('product', 'categories', 'attributes'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'categories' => 'required|array',
            'attributes' => 'nullable|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required',
        ]);

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $product->categories()->sync($data['categories']);

        $product->attributes()->detach();
        foreach ($data['attributes'] as $attribute) {
            $product->attributes()->attach($attribute['id'], ['value' => $attribute['value']]);
        }

        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
