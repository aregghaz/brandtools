<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SelectCollection extends ResourceCollection
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
                'label' => $data->slug,
                'name' => $data->title,
                "value"=> $data->pivot->value ?? $data->id,
            ];
        });
    }
}
