<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
                'price' => $data->price,
                "special_price" => $data->special_price,
                "slug" => $data->slug,
                "conditions" => $data->condition ? $data->condition->title : '--',
                "teg" => $data->teg ? $data->teg->title : '--',
                "brand" => $data->brand ? $data->brand->title : '--',
                "categories" => $data->categories ? $data->categories->title : '--',
                'description' => $data->description || '--',
                "updated" => $data->updated_at,
            ];
        });
    }
}
