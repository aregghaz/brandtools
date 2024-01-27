<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryShortCollection;
use App\Http\Resources\PorductShortCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function singleProduct($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::find($id);

        return response()->json([
                'id' => $product->id,
                'title' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'special_price' => $product->special_price,
                'start' => $product->start,
                'end' => $product->end,
                'teg_id' => $product->teg_id,
                'categories' => new SelectCollection($product->categories),
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
                'meta_key' => $product->meta_key,]
        );
    }

    public function getByTeg($getByTeg, $limit, Request $request)
    {
        $products = Product::where(['teg_id' => $getByTeg, 'status' => 1])->limit($limit)->get();
        return response()->json(new PorductShortCollection($products));
    }

    public function category(Request $request)
    {
        $category = Category::with('children')->select('id','title','parent_id')->get();
        return response()->json(new CategoryShortCollection($category));
    }

    public function productsCategory($id,$limit, Request $request) {
       $products = Product::whereHas('categories', function ($query) use ($id){
           $query->where('categories.id',$id);
       })->limit($limit)->get();
        return response()->json(new PorductShortCollection($products));
    }
    public function singleCategory($id) {
        $category = Category::with('children')->find($id);
        return response()->json([
            'id' => $category->id,
            'title' => $category->title,
            'children' => new CategoryShortCollection($category->children)
        ]);
    }
    public function singleCat($id) {
        $category = Category::find($id);
        return response()->json($category);
    }


}
