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

        $category = Category::create([
            'title' => $data->title,

            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description ?? null,
            'meta_title' => $data->meta_title ?? null,
            'meta_desc' => $data->meta_desc ?? null,
            'meta_key' => $data->meta_key ?? null,
            'status' => 1,
            'top' => $data->top->id ?? 0,
            'image' => '/storage/'.explode("storage", $data->image)[1],
            'banner' => '/storage/'.explode("storage", $data->banner)[1],
            'icon' => '/storage/'.explode("storage", $data->icon)[1],

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
                'icon' => url($category->icon),
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
        $category->update([
            'title' => $data->title,
            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
            'top' => $data->top->id ?? 0,
            'status' => (int)$data->status->id,
            'image' => '/storage/'.explode("storage", $data->image)[1],
            'banner' => '/storage/'.explode("storage", $data->banner)[1],
            'icon' => '/storage/'.explode("storage", $data->icon)[1],
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
        $categories = Category::whereIn('id', $request->ids)->get();
        foreach ($categories as $category) {
            $this->deleteCategory($category);
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    public function deleteCategory(Category $category): bool
    {
        $category->attributes()->detach();
        $category->delete();
        return true;
    }
}
