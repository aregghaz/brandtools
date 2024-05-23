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
        $data = explode(' ' ,$request['query']);

        $products = Product::where('status', 1)
            ->Where(function ($query) use($data) {
                for ($i = 0; $i < count($data); $i++){
                    $query->orwhere('name', 'LIKE', '%' . $data[$i] . '%');
                    $query->orwhere('slug', 'LIKE', '%' . $data[$i] . '%');
                }
            })
            ->limit($limit)->get();
        return response()->json([
            'products' => new PorductShortCollection($products)
        ]);
    }

    public function groupDeletePrice(Request $request){
        Product::where('status', 1)->update([
            "special_price" => 0,
            'start'=>null,
            'end'=>null
        ]);
        return response()->json([
            'status' => 200
        ]);
    }
}
