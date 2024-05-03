<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListAdminCollection;
use App\Http\Resources\OrdersListCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $queryData = $request->get('query');
        $orders = Order::with('products');
        if (isset($queryData)) {
            $this->orderQuery($queryData, $orders);
        }
        $orders = $orders->orderBy('id', 'DESC')->take(15 * $showMore)->get();
        return response()->json(new OrderListAdminCollection($orders));
    }

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
        $order = Order::with('products.item', 'user')->find($id);

        if ($order) {
            return response()->json($order);
        } else {
            return response()->json([
                'message' => 'not found',
                'success' => 0
            ]);
        }
    }

    public function getLatestOrders()
    {
        $orders = Order::with('user')
            ///->whereIn('status', [1,2])
            ->orderBy('orders.id', 'DESC')
            ->take(10)
            ->get();
        return response()->json([
            'orders' => new OrderListAdminCollection($orders),
            'success' => 0
        ]);
    }

    public function destroy($id)
    {
        Order::find($id)->delete();
        return response()->json([
            "status" => 200,
        ]);

    }

    public function changeStatus(Request $request)
    {
        Order::whereIn('id', $request->ids)->update(['status'=> $request->statusId]);
        return response()->json([
            "status" => 200,
        ]);
    }
    public function getStatusSelect(Request $request)
    {
        $status = Status::all();
        return response()->json([
            'data'=>new SelectCollection($status),
            "status" => 200,
        ]);
    }
}
