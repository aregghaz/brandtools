<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $showMore = $request->get('showMore');

        $categories = Category::with('parent')->take(15 * $showMore)->orderBy('id', 'DESC')->get();
        return response()->json(new CategoryCollection($categories));

    }

    public function create()
    {
        $categories = Category::all();
        $data = [
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
            "categories" => new SelectCollection($categories),
            "status" => new SelectCollection($data)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);

        $categories = Category::create([
            'title' => $data->title,
            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
            'status' => $data->status ? (int)$data->status->id : 0,
        ]);
        return response()->json($categories);
        /// return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $data = [
            (object)[
                "id" => 1,
                "title" => "enable"
            ],
            (object)[
                "id" => 2,
                "title" => "disable"
            ]
        ];
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
                'categories' => $category->parent ? [
                    "id" => $category->parent->id,
                    "value" => $category->parent->id,
                    "label" => $category->parent->title,
                    "name" => $category->parent->title,
                ] : null,
                'status' => [
                    "id" => $category->status,
                    "value" => $category->status,
                    "label" => $category->status === 1 ? 'enable' : 'disable',
                    "name" => $category->status === 1 ? 'enable' : 'disable',
                ],
                "updated_at" => $category->updated_at,
            ],
            "categories" => new SelectCollection($categories),
            "status" => new SelectCollection($data)
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
        $categories = $category->update([
            'title' => $data->title,
            'parent_id' => isset($data->categories) ? $data->categories->id : null,
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
            'status' => (int)$data->status->id,
        ]);

        return response()->json([
            'categories' => $categories,
            'status' => 200
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => 200
        ]);
    }
}
