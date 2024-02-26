<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImagesCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $queryData = $request->get('query');
        $products = Product::with('teg', 'brand', 'categories');
        if (isset($queryData)) {
            $this->convertQuery($queryData, $products, 1);
        }
        $products = $products->take(15 * $showMore)->orderBy('id', 'DESC')->get();

        return response()->json(new ProductCollection($products));
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::all();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return response()->json([
            'status' => new SelectCollection($this->simpleSelect()),
            'brand_id' => new SelectCollection($brands),
            'categories' => new SelectCollection($categories),
            'attributes' => new SelectCollection($attributes),
        ]);
    }

    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::all();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();

        return response()->json([
            'data' => [
                'id' => $product->id,
                'title' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'special_price' => $product->special_price,
                'range' => [
                    $product->start,
                    $product->end,
                ],
                'teg_id' => $product->teg_id,
                'categories' => new SelectCollection($product->categories),
                'attributes' => new SelectCollection($product->attributes),
                'brand_id' => [
                    "name" => $product->brand->title,
                    "label" => $product->brand->title,
                    "value" => $product->brand->id,
                    "id" => $product->brand->id
                ],
                'sku' => $product->sku,
                'quantity' => $product->quantity,
                'image' => $product->image,
                'status' => [
                    "name" => $product->status === 1 ? 'включено' : "отключить",
                    "label" => $product->status === 1 ? 'включено' : "отключить",
                    "value" => $product->status,
                    "id" => $product->status
                ],
                'meta_title' => $product->meta_title,
                'meta_desc' => $product->meta_desc,
                'meta_key' => $product->meta_key,
            ],
            'images' => new ImagesCollection($product->images),
            'status' => new SelectCollection($this->simpleSelect()),
            'brand_id' => new SelectCollection($brands),
            'categories' => new SelectCollection($categories),
            'attributes' => new SelectCollection($attributes),
        ]);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->value);

        $product = Product::create([
            'name' => $data->title,
            'description' => $data->description ?? null,
            'price' => $data->price,
            'special_price' => $data->special_price ?? 0,
            'start' => $data->range[0] ? date_create($data->range[0])->format('Y-m-d') : null,
            'end' => $data->range[1] ? date_create($data->range[1])->format('Y-m-d') : null,
//            'slug',
            'teg_id' => isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => $data->brand_id->id || null,
//            'sku',
            'quantity' => $data->quantity,
//            'image',
            'status' => 1,
            'meta_title' => $data->meta_title ?? '',
            'meta_desc' => $data->meta_desc ?? '',
            'meta_key' => $data->meta_key ?? "",
        ]);
        // $product->categories()->sync($data->categories->id);
        if (isset($data->attributes)) {
            foreach ($data->attributes as $attribute) {
                $idData = "$attribute->id";
                $product->attributes()->attach($attribute->id, ['value' => $data->$idData]);
            }
        }

        foreach ($data->categories as $categories) {
            $product->categories()->attach($categories->id);
        }
        return response()->json([
            "status" => 200,
        ]);
    }

//    public function edit(Product $product)
//    {
//        $categories = Category::all();
//        $attributes = Attribute::all();
//        return view('products.edit', compact('product', 'categories', 'attributes'));
//    }

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
            'special_price' => $data->special_price,
            'start' => $data->range[0] ? date_create($data->range[0])->format('Y-m-d') : null,
            'end' => $data->range[1] ? date_create($data->range[1])->format('Y-m-d') : null,
            'teg_id' => isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => $data->brand_id->id || null,
//            'sku',
            'quantity' => $data->quantity,
//            'image',
            'status' => $data->status->id || null,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
        ]);


        $product->attributes()->detach();
        foreach ($data->attributes as $attribute) {
            $idData = "$attribute->id";
            $product->attributes()->attach($attribute->id, ['value' => $data->$idData]);
        }
        $product->categories()->detach();
        foreach ($data->categories as $categories) {
            $product->categories()->attach($categories->id);
        }


        return response()->json([
            'status' => 200
        ]);
    }

    public function destroy(Product $product)
    {

        $this->deleteProduct($product);
        return response()->json([
            'status' => 200
        ]);
    }

    public function upload(Request $request)
    {
        $id = $request->id;
        foreach ($request->images as $index => $image) {
            $file = $image['img'];
            $storagePath = Storage::put("public/images/products", $file);
            $storageName = "/storage/images/products/" . basename($storagePath);
            ProductImage::create([
                "path" => $storageName,
                "product_id" => (int)$id,
                "sort" => $index,
            ]);
        }

        return response()->json([
            'status' => 200
        ]);
    }

    public function deleteImage($id, Request $request)
    {
        $productImage = ProductImage::find($id);
        $imageFile = explode('/', $productImage->path);
        Storage::delete("/public/images/products/" . $imageFile[count($imageFile) - 1]);
        $productImage->delete();
        return response()->json([
            'status' => 200
        ]);
    }

    public function getImages($id, Request $request)
    {
        $images = ProductImage::where('product_id', $id)->get();
        return response()->json([
            'status' => 200,
            "data" => new ImagesCollection($images)
        ]);
    }

    public function groupDelete(Request $request)
    {
        $products = Product::whereIn('id', $request->ids)->with('images')->get();
        foreach ($products as $product) {
            $this->deleteProduct($product);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product): void
    {
        $imageFile = explode('/', $product->image);
        Storage::delete("/public/images/products/" . $imageFile[count($imageFile) - 1]);
        if (count($product->images) > 0) {
            foreach ($product->images as $images) {
                $imageFile = explode('/', $images->path);
                Storage::delete("/public/images/products/" . $imageFile[count($imageFile) - 1]);
            }
        }
        $product->categories()->detach();
        $product->attributes()->detach();
        $product->delete();
    }
}
