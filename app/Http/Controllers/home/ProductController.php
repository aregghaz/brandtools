<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\PorductShortCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getTopProducts(Request $request, $limit)
    {
        $products = Product::where('end', '>', date('Y-m-d'))
            ->where('special_price', '>', 0)
            ->where("status", 1)->limit($limit)->get();
        return response()->json([
            'products' => new PorductShortCollection($products)
        ]);
    }

    public function searchProducts(Request $request, $limit): \Illuminate\Http\JsonResponse
    {

        $products = Product::where('status', 1)->where('name', 'LIKE', '%' . $request['query'] . '%')->orWhere('slug', 'LIKE', '%' . $request['query'] . '%')->limit($limit)->get();
        return response()->json([
            'products' => new PorductShortCollection($products)
        ]);
    }
}
