<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryGroupCollection;
use App\Http\Resources\ImagesCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Teg;
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
        $products = $products->take(40 * $showMore)->orderBy('id', 'DESC')->get();

        return response()->json(new ProductCollection($products));
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::orderBy('title', 'ASC')->get();
        $categories = Category::all();
        $tags = Teg::all();
        $attributes = Attribute::with('values')->get();
        return response()->json([
            'status' => new SelectCollection($this->simpleSelect()),
            'brand_id' => new SelectCollection($brands),
            'categories' => new CategoryGroupCollection($categories),
            'attributes' => new SelectCollection($attributes),
            'teg_id' => new SelectCollection($tags),
        ]);
    }

    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::orderBy('title', 'ASC')->get();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        $tags = Teg::all();

        return response()->json([
            'data' => [
                'id' => $product->id,
                'title' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'special_price' => $product->special_price,
                'range' => [
                    $product->start,
                    $product->end,
                ],
                'categories' => new SelectCollection($product->categories),
                'attributes' => new SelectCollection($product->attributes),
                'brand_id' => isset($product->brand) ? [
                    "name" => $product->brand->title,
                    "label" => $product->brand->title,
                    "value" => $product->brand->id,
                    "id" => $product->brand->id
                ] : null,
                'teg_id' => [
                    "name" => $product->teg ? $product->teg->title : null,
                    "label" => $product->teg ? $product->teg->title : null,
                    "value" => $product->teg ? $product->teg->id : null,
                    "id" => $product->teg ? $product->teg->id : null
                ],
                'sku' => $product->sku,
                'quantity' => $product->quantity,
                'image' => url($product->image),
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
            'categories' => new CategoryGroupCollection($categories),
            'attributes' => new SelectCollection($attributes),
            'teg_id' => new SelectCollection($tags),
        ]);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->value);
        $storageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/products", $file);
            $storageName = "/storage/images/products/" . basename($storagePath);
        }
        $product = Product::create([
            'name' => $data->title,
            'description' => $data->description ?? null,
            'price' => $data->price,
            'special_price' => isset($data->range) ? $data->special_price : 0,
            'start' => isset($data->range) && $data->range[0] ? date_create($data->range[0])->format('Y-m-d') : null,
            'end' => isset($data->range) && $data->range[1] ? date_create($data->range[1])->format('Y-m-d') : null,
//            'slug',
            'teg_id' => isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => isset($data->brand_id->id) ? $data->brand_id->id : null,
//            'sku',
            'quantity' => $data->quantity,
            'stock' => $data->stock ?? '',
            'image' => $storageName,
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

        if ($request->hasFile('image')) {
            $imageFile = explode('/', $product->image);
            Storage::delete("public/images/products/" . $imageFile[count($imageFile) - 1]);
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/products", $file);
            $storageName = "/storage/images/products/" . basename($storagePath);
            $product->update([
                'image' => $storageName,
            ]);
        }
        $product->update([
            'name' => $data->title,
            'description' => $data->description,
            'price' => $data->price,
            'special_price' => $data->special_price,
            'start' => (!is_string($data->range) and $data->range[0]) ? date_create($data->range[0])->format('Y-m-d') : null,
            'end' => (!is_string($data->range) and $data->range[1]) ? date_create($data->range[1])->format('Y-m-d') : null,
            'teg_id' => isset($data->teg_id) ? $data->teg_id->id : null,
            'brand_id' => isset($data->brand_id->id) ? $data->brand_id->id : null,
//            'sku',
            'stock' => $data->stock ?? '',
            'quantity' => $data->quantity,
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

    function getSubCategoryIds($childCategories, int $parentId): array
    {
        if ($parentId === 0) {
            return [];
        }
        // Get all of the child categories of the parent category.
        $subcategoryIds = [];
        foreach ($childCategories as $childCategory) {
            $subcategoryIds[] = $childCategory->id;
            $subcategoryIds = array_merge($subcategoryIds, $this->getSubCategoryIds($childCategory->allParents, $childCategory->id,));
        }
        return $subcategoryIds;
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
        $images = ProductImage::where('product_id', $id)->get();
        return response()->json([
            "data" => new ImagesCollection($images),
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

    public function groupAddTag(Request $request)
    {
        $tagId = $request->tagId;
        $products = Product::whereIn('id', $request->ids)->with('images')->get();
        foreach ($products as $product) {
            $product->update('teg_id', $tagId);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function addDiscount(Request $request)
    {
        $values = $request->value;
        $ids = $request->ids;
        $products = Product::where('status', 1)->get();
        foreach ($products as $product) {
            $product->update([
                'special_price' => round($product->price - ($product->price * (int)$values['discount']) / 100),
                'start' => date_create($values['dates'][0])->format('Y-m-d'),
                'end' => date_create($values['dates'][1])->format('Y-m-d'),
            ]);
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
