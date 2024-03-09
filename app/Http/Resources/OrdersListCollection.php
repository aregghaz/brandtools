<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($product) {
            $images = explode('.JPG', $product->image);
            return [
                'id' => $product->id,
                'count'=> count($product->products),
                'status' => $product->status,
                'total' => $product->grant_total,
                'created' => $product->created_at,

            ];
        });
    }
}
