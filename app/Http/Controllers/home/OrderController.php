<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersListCollection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders(Request $request, $limit)
    {
        $id = $request->user()->id;
        $orders = Order::where('user_id', $id)->with('products')->orderBy('id', 'DESC')->limit($limit)->paginate($limit);
//        dd($orders->total());
        return response()->json([
            'perPage' => $limit,
            "data" => new OrdersListCollection($orders),
            "lastPage" => $orders->lastPage(),
            "total" => $orders->total(),
        ]);
    }

    public function getSingleOrder(Request $request, $id)
    {

        $userId = $request->user()->id;
        $order = Order::with('products', 'address')->find($id);

        if ($order and $order->user_id === $userId) {
            return response()->json($order);
        } else {
            return response()->json([
                'message' => 'not found',
                'success' => 0
            ]);
        }
    }

}
