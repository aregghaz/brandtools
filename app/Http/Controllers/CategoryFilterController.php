<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryFilterController extends Controller
{
    public function filter(Request $request, Category $category)
    {
        $attributeIds = $request->input('attributes', []);

        // Use the productsWithAttributes method from the Category model
        $products = $category->productsWithAttributes($attributeIds);

        return view('categories.filtered', compact('category', 'products'));
    }
}
