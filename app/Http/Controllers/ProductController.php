<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('teg', 'brand', 'condition', 'categories')->get();
        return response()->json(new ProductCollection($products));
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::all();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        $conditions = Condition::all();
        return response()->json([
            'brands' => new SelectCollection($brands),
            'categories' => new SelectCollection($categories),
            'attributes' => new SelectCollection($attributes),
            'conditions' => new SelectCollection($conditions)
        ]);
        ///  return view('products.create', compact('categories', 'attributes'));
    }

    public function store(Request $request)
    {
//        $data = json_decode($request->value);
//        var_dump($data);
//        $data->validate([
//            'title' => 'required|string',
//            'description' => 'nullable|string',
//            'categories' => 'required|array',
//            'attributes' => 'nullable|array',
//            'attributes.*.id' => 'required|exists:attributes,id',
//            'attributes.*.value' => 'required',
//        ]);
        $data = json_decode($request->value);
        var_dump($data->conditions->id);
        $product = Product::create([
            'name' => $data->title,
            'description' => $data->description,
            'condition_id' => $data->conditions->id,
            'brand_id' => $data->brands->id,
            'price' => $data->price,
            'category_id' => $data->categories->id,
        ]);

        foreach ($data->attributes as $attribute) {
            $product->attributes()->attach($attribute->id, ['value' => $attribute->value]);
        }

        return response()->json($product);
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
        return response()->json([
            'status' => 200
        ]);
    }
}
