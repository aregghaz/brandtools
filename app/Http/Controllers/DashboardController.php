<?php

namespace App\Http\Controllers;

use App\Http\Resources\MonthOrderStatusCollection;
use App\Http\Resources\YearProfitCollection;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function yearProfit(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::select(
            DB::raw('year(created_at) as year'),
            DB::raw('month(created_at) as month'),
            DB::raw('sum(grant_total) as price'),
        )
            ->where(DB::raw('date(created_at)'), '>=', "2010-01-01")
            ->groupBy('year')
            ->groupBy('month')
            ->get()
            ->toArray();

        return response()->json(new YearProfitCollection($orders));
    }
    public function orderCount(): \Illuminate\Http\JsonResponse
    {
        $orders = Order::select(
            DB::raw('month(created_at) as month'),
            DB::raw('status as status'),
            DB::raw('count(status) as count'),
        )
            ->where(DB::raw('date(created_at)'), '>=', "2024-01-01")
            ->whereIn('status',[4,5])
            ->groupBy('month')
            ->groupBy('status')
            ->get()
            ->toArray();

//        $orders
//        { name: string; complete: number, decline:number }
        return response()->json(new MonthOrderStatusCollection($orders));
    }


}
