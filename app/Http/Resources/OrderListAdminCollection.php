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
        return $this->map(function ($order) {
            $status = Status::find($order->status);

            return [
                'id' => $order->id,
                'orderId' => $order->id,
                'name' => $order->user->name.' '. $order->user->lastName,
                'status' => $status->title,
                'status_id' => $order->status,
                'total' => $order->grant_total,
                'updated' => $order->created_at,

            ];
        });
    }
}
