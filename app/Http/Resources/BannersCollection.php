<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BannersCollection extends ResourceCollection
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
                'position' => $data->position,
                "updated"=> $data->updated_at,
            ];
        });
    }
}
