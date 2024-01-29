<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandCollection extends ResourceCollection
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
                'image' => $data->image,
                'title' => $data->title,
                'slug' => $data->slug,
//                'description' => $data->description,
                "updated"=> $data->updated_at,
            ];
        });
    }
}
