<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
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
                'type' => (int)$data->type === 1 ? 'select' : 'range',
                "updated_at" => $data->updated_at,
            ];
        });
    }
}
