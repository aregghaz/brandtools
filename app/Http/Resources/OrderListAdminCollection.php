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
                'name' =>  isset($order->user) ?$order->user->lastName. ' '.$order->user->name .' '.$order->user->fatherName : 'deleted user',
                'status' => $status->title,
                'status_id' => $order->status,
                'total' => $order->grant_total,
                'updated' => $order->created_at,

            ];
        });
    }
}
