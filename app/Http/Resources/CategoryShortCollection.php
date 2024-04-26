<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryShortCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($category) {

            return [
                'id' => $category->id,
                'title' => $category->title,
                'image' => $category->image,
                'icon' => $category->icon,
                'slug' => $category->slug,
                'children' => new CategoryShortCollection($category->children)
            ];
        });
    }
}
