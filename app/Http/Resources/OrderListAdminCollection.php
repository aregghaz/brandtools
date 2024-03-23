<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderListAdminCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($product) {
            $status = Status::find($product->status);

            return [
                'id' => $product->id,
                'name' => $product->user->name.' '. $product->user->lastName,
                'status' => $status->title,
                'total' => $product->grant_total,
                'updated' => $product->created_at,

            ];
        });
    }
}
