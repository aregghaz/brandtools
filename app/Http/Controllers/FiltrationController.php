<?php

namespace App\Http\Controllers;

use App\Http\Resources\PorductShortCollection;
use App\Models\Product;
use Illuminate\Http\Request;


class FiltrationController extends Controller
{
    public function index($id, $limit, Request $request)
    {

        $filt = $request->criteria;
        $ids = [];
        $values = [];
        $checkPrice = false;
        $priceValue = [];
        if(isset($filt)){
            foreach ($filt as  $attribute) {
                if(key((array)$attribute) !== 9999){
                    $ids[] = key((array)$attribute);
                    $values[] = value((array)$attribute);
                }else{
                    $checkPrice = true;
                    $priceValue = value((array)$attribute);
                }
            }
        }



        $products = Product::where('status',1)
            ->with(['attributes', 'categories' => function ($q) use ($id) {
            $q->where('categories.id', $id);
        }]);
            if($checkPrice){
                $products = $products->whereBetween('price', [$priceValue[0], $priceValue[1]]);

            }

        $products = $products->whereHas('attributes', function ($query) use ($ids, $values) {
            $query->whereIn('attributes.id', $ids);
            $query->whereIn('value', $values);
        });


        $products = $products->limit($limit)->get();


        return response()->json(new PorductShortCollection($products));
    }
}
