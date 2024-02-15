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

        $products = Product::where('start', '<', date('Y-m-d'))->where('end', '>', date('Y-m-d'))->where('special_price', '>', 0)->limit($limit)->get();
        return response()->json([
            'products' => new PorductShortCollection($products)
        ]);

    }
}
