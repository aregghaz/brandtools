<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagsCollection extends ResourceCollection
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
                'position' => $data->position,
                'updated' => $data->updated_at
            ];
        });
    }
}
