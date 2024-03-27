<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $showMore = $request->get('showMore');
        $queryData = $request->get('query');
        $categories = Category::with('parent');
        if (isset($queryData)) {
            $this->convertQuery($queryData, $categories, 2);
        }
        $categories = $categories->take(15 * $showMore)->orderBy('id', 'DESC')->get();

        return response()->json(new CategoryCollection($categories));
    }

    public function categoryTree()
    {
        $data = Category::with('tree')->get();
        dd($data);
    }

    public function create(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        return response()->json([
            "categories" => new SelectCollection($categories),
            'status' => new SelectCollection($this->simpleSelect()),
            'top' => new SelectCollection($this->simpleSelect()),
            'attributes' => new SelectCollection($attributes),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $storageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/category", $file);
            $storageName = "/storage/images/category/" . basename($storagePath);
        }
        $storageBanner = null;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $storagePath = Storage::put("public/images/category", $file);
            $storageName = "/storage/images/category/" . basename($storagePath);
        }
        $category = Category::create([
            'title' => $data->title,
            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description ?? null,
            'meta_title' => $data->meta_title ?? null,
            'meta_desc' => $data->meta_desc ?? null,
            'meta_key' => $data->meta_key ?? null,
            'status' => 1,
            'top' => $data->top->id ?? 0,
            'image' => $storageName,
            'banner' => $storageBanner
        ]);
        if (isset($data->attributes)) {
            foreach ($data->attributes as $attribute) {
                $category->attributes()->attach($attribute->id);
            }
        }

        return response()->json([
            "status" => 200,
        ]);
    }

    public function show(Category $category): \Illuminate\Http\JsonResponse
    {
        $attributes = Attribute::all();
        $categories = Category::all();
        return response()->json([
            "data" => [
                "id" => $category->id,
                "title" => $category->title,
                "slug" => $category->slug,
                'description' => $category->description,
                'meta_title' => $category->meta_title,
                'meta_desc' => $category->meta_desc,
                'meta_key' => $category->meta_key,
                'image' => url($category->image),
                'banner' => url($category->banner),
                'attributes' => new SelectCollection($category->attributes),
                'categories' => $category->parent ? [
                    "id" => $category->parent->id,
                    "value" => $category->parent->id,
                    "label" => $category->parent->title,
                    "name" => $category->parent->title,
                ] : null,
                'status' => [
                    "id" => $category->status,
                    "value" => $category->status,
                    "label" => $category->status === 1 ? 'включено' : 'отключить',
                    "name" => $category->status === 1 ? 'включено' : 'отключить',
                ],
                'top' => [
                    "id" => $category->top,
                    "value" => $category->top,
                    "label" => $category->top === 1 ? 'включено' : 'отключить',
                    "name" => $category->top === 1 ? 'включено' : 'отключить',
                ],
                "updated_at" => $category->updated_at,
            ],
            'top' => new SelectCollection($this->simpleSelect()),
            "categories" => new SelectCollection($categories),
            'status' => new SelectCollection($this->simpleSelect()),
            'attributes' => new SelectCollection($attributes),
        ]);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        if ($request->hasFile('image')) {
            $imageFile = explode('/', $category->image);
            Storage::delete("public/images/category/" . $imageFile[count($imageFile) - 1]);
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/category", $file);
            $storageName = "/storage/images/category/" . basename($storagePath);
            $category->update([
                'image' => $storageName,
            ]);
        }
        if ($request->hasFile('banner')) {
            $imageFile = explode('/', $category->banner);
            Storage::delete("public/images/category/" . $imageFile[count($imageFile) - 1]);
            $file = $request->file('banner');
            $storagePath = Storage::put("public/images/category", $file);
            $storageName = "/storage/images/category/" . basename($storagePath);
            $category->update([
                'banner' => $storageName,
            ]);
        }
        $category->update([
            'title' => $data->title,
            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
            'top' => $data->top->id ?? 0,
            'status' => (int)$data->status->id,
        ]);
        $category->attributes()->detach();
        foreach ($data->attributes as $attribute) {
            $category->attributes()->attach($attribute->id);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        //$this->deleteCategory($category);
      //  return response()->json($category->children);
        foreach ($category->children as $child){
            $this->deleteCategory($child);
        }
        $this->deleteCategory($category);
        return response()->json([
            'status' => 200
        ]);
    }

    public function groupDelete(Request $request)
    {
        $categories = Category::whereIn('id', $request->ids)->with('images')->get();
        foreach ($categories as $category) {
            $this->deleteCategory($category);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function deleteCategory(Category $category): bool
    {
        $imageFile = explode('/', $category->image);
        Storage::delete("/public/images/category/" . $imageFile[count($imageFile) - 1]);
        $imageFile = explode('/', $category->banner);
        Storage::delete("public/images/category/" . $imageFile[count($imageFile) - 1]);
        $category->attributes()->detach();
        $category->delete();
        return true;
    }
}
