<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->get();
        return response()->json(new CategoryCollection($categories));

    }

    public function create()
    {
        $categories = Category::all();
        return response()->json(["categories" => new SelectCollection($categories)]);
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
        ]);
        return response()->json($categories);
        /// return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $categories = Category::all();
        return response()->json([
            "data" => [
                "id" => $category->id,
                "title" => $category->title,
                "slug" => $category->slug,
                'categories' =>$category->parent ? [
                    "id" => $category->parent->id,
                    "value" => $category->parent->id,
                    "label" => $category->parent->title,
                    "name" => $category->parent->title,
                ] : null,
                "updated_at" => $category->updated_at,
            ],
            "categories" => new SelectCollection($categories)
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
            'parent_id' => isset($data->categories)  ? $data->categories->id : null,
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
