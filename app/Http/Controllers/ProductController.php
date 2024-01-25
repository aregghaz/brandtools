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

    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $products = Product::with('teg', 'brand', 'condition', 'categories')->take(15 * $showMore)->orderBy('id', 'DESC')->get();
        return response()->json(new ProductCollection($products));
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        $status = [
            (object)[
                "id" => 1,
                "title" => "enable"
            ],
            (object)[
                "id" => 2,
                "title" => "disable"
            ]
        ];
        $brands = Brand::all();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        $conditions = Condition::all();
        return response()->json([
            'status' => new SelectCollection($status),
            'brand_id' => new SelectCollection($brands),
            'categories' => new SelectCollection($categories),
            'attributes' => new SelectCollection($attributes),
            'condition_id' => new SelectCollection($conditions)
        ]);
    }

    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::all();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        $conditions = Condition::all();
        $status = [
            (object)[
                "id" => 1,
                "title" => "enable"
            ],
            (object)[
                "id" => 2,
                "title" => "disable"
            ]
        ];

        return response()->json([
            'data' => [
                'id' => $product->id,
                'title' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'special_price' => $product->special_price,
                'start' => $product->start,
                'end' => $product->end,
                'teg_id' => $product->teg,
                 'categories' => new SelectCollection( $product->categories),
                'attributes' => new SelectCollection($product->attributes),
                'brand_id' => [
                    "name" => $product->brand->title,
                    "label" => $product->brand->title,
                    "value" => $product->brand->id,
                    "id" => $product->brand->id
                ],
                'condition_id' => $product->condition ? [
                    "name" => $product->condition->title,
                    "label" => $product->condition->title,
                    "value" => $product->condition->id,
                    "id" => $product->condition->id
                ] : '',
                'sku' => $product->sku,
                'quantity' => $product->quantity,
                'image' => $product->image,
                'status' => [
                    "name" => $product->status === 1 ? 'enable' : "disable",
                    "label" => $product->status === 1 ? 'enable' : "disable",
                    "value" => $product->status,
                    "id" => $product->status
                ],
                'meta_title' => $product->meta_title,
                'meta_desc' => $product->meta_desc,
                'meta_key' => $product->meta_key,
            ],
            'status' => new SelectCollection($status),
            'brand_id' => new SelectCollection($brands),
            'categories' => new SelectCollection($categories),
            'attributes' => new SelectCollection($attributes),
            'condition_id' => new SelectCollection($conditions)
        ]);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->value);
        $product = Product::create([
            'name' => $data->title,
            'description' => $data->description,
            'price' => $data->price,
            'special_price'=> $data->special_price,
//            'start',
//            'end',
//            'slug',
            'teg_id'=> isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => $data->brand_id->id || null,
            'condition_id'=> isset($data->condition_id) ? $data->condition_id->id : null,
//            'sku',
            'quantity'=> $data->quantity,
//            'image',
            'status'=>$data->status->id || null,
            'meta_title'=> $data->special_price,
            'meta_desc'=> $data->special_price,
            'meta_key'=> $data->special_price,
        ]);
       // $product->categories()->sync($data->categories->id);
        foreach ($data->attributes as $attribute) {
            $product->attributes()->attach($attribute->id, ['value' => $attribute->value]);
        }
        foreach ($data->categories as $categories) {
            $product->categories()->attach($categories->id);
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
//        $data = $request->validate([
//            'name' => 'required|string',
//            'description' => 'nullable|string',
//            'categories' => 'required|array',
//            'attributes' => 'nullable|array',
//            'attributes.*.id' => 'required|exists:attributes,id',
//            'attributes.*.value' => 'required',
//        ]);
        $data = json_decode($request->value);
        $product->update([
            'name' => $data->title,
            'description' => $data->description,
            'price' => $data->price,
            'special_price'=> $data->special_price,
//            'start',
//            'end',
//            'slug',
            'teg_id'=> isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => $data->brand_id->id || null,
            'condition_id'=> isset($data->condition_id) ? $data->condition_id->id : null,
//            'sku',
            'quantity'=> $data->quantity,
//            'image',
            'status'=>$data->status->id || null,
            'meta_title'=> $data->special_price,
            'meta_desc'=> $data->special_price,
            'meta_key'=> $data->special_price,
        ]);


        $product->attributes()->detach();
        foreach ($data->attributes as $attribute) {
            $product->attributes()->attach($attribute->id, ['value' => $attribute->value]);
        }
        $product->categories()->detach();
        foreach ($data->categories as $categories) {
            $product->categories()->attach($categories->id);
        }


        return response()->json([
            'product' => $product,
            'status' => 200
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => 200
        ]);
    }
}
