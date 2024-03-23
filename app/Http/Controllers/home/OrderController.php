<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListAdminCollection;
use App\Http\Resources\OrdersListCollection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $queryData = $request->get('query');
        $orders = Order::with('products');
//        if (isset($queryData)) {
//            $this->convertQuery($queryData, $orders, 3);
//        }
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
        $order = Order::with('products.item', 'user', 'address')->find($id);

        if ($order and $order->user_id === $userId) {
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
            ->join('statuses', 'statuses.id', '=', 'orders.status')
            /// ->where('status', 1)
            ->orderBy('orders.id', 'DESC')
            ///->select(['orders.id as odId' ,'statuses.title as title','statuses.id as id'])
            ->take(20)
            ->get();
        return response()->json([
            'orders' => new OrderListAdminCollection($orders),
            'success' => 0
        ]);
    }
    public function destroy($id){
        Order::find($id)->delete();
        return response()->json([
            "status" => 200,
        ]);

    }
}
