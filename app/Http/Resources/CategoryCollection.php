<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *

     */
    public function toArray(Request $request)
    {
        return $this->map(function ($data) {
            return [
                'id' => $data->id,
                'title' => $data->title,
                'slug' => $data->slug,
                'parent' => $data->parent_id ? $data->parent->title : '--',
                "updated_at"=> $data->updated_at,
            ];
        });
    }
}
