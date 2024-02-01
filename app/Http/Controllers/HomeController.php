<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannersCollection;
use App\Http\Resources\BrandsCollection;
use App\Http\Resources\CategoryShortCollection;
use App\Http\Resources\PorductShortCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Teg;
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

    public function getByTeg($getByTeg, $limit, Request $request): \Illuminate\Http\JsonResponse
    {
        $products = Product::where(['teg_id' => $getByTeg, 'status' => 1])->limit($limit)->get();
        return response()->json(new PorductShortCollection($products));
    }

    public function category(Request $request): \Illuminate\Http\JsonResponse
    {
        $category = Category::with('children')->select('id', 'title', 'parent_id')->get();
        return response()->json(new CategoryShortCollection($category));
    }

    public function productsCategory($id, $limit, Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Category::with(['products' => function ($query) use ($limit) {
            $query->limit($limit);
        }])->find($id);


        return $this->getJsonResponse($data);
    }

    public function singleCategory($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::with('children')->find($id);
        return response()->json([
            'id' => $category->id,
            'title' => $category->title,
            'children' => new CategoryShortCollection($category->children)
        ]);
    }

    public function singleCat($id, $limit): \Illuminate\Http\JsonResponse
    {
        $category = Category::with([
            'attributes',
            'products' => function ($q) use ($limit) {
                $q->limit($limit);
            },
            'attributes.values' => function ($q) {
                $q->distinct('value');
            }])->find($id);

        return response()->json($category);
    }

    public function getTags(): \Illuminate\Http\JsonResponse
    {
        $tags = Teg::all();
        return response()->json(new SelectCollection($tags));
    }

    public function getBrand($limit): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::limit($limit)->get();
        return response()->json(new BrandsCollection($brands));
    }

    public function getSingleBrand($id): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::find($id);
        return response()->json($brands);
    }

    public function brandProducts($id, $limit): \Illuminate\Http\JsonResponse
    {
        $data = Brand::with(['products' => function ($query) use ($limit) {
            $query->limit($limit);
        }])->find($id);
        return $this->getJsonResponse($data);
    }

    public function getBanners(): \Illuminate\Http\JsonResponse
    {
        $data = Banner::all();
        return response()->json(new BannersCollection($data));
    }


    public function getJsonResponse(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null $data): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'id' => $data->id,
            'title' => $data->title,
            'description' => $data->description,
            'meta_title' => $data->meta_title ?? '--',
            'meta_desc' => $data->meta_desc ?? '--',
            'meta_key' => $data->meta_key ?? '--',
            'status' => $data->status ?? '--',
            'image' => $data->image ?? '--',
            "updated" => $data->updated_at,
            'products' => new PorductShortCollection($data->products),
        ]);
    }
}
