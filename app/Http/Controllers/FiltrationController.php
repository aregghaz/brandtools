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
        foreach ($filt as $key => $attribute) {
            $ids[] = key((array)$attribute);
            $values[] = value((array)$attribute);
        }


        $products = Product::where('status',1)->with(['attributes', 'categories' => function ($q) use ($id) {
            $q->where('categories.id', $id);
        }]);


        $products = $products->whereHas('attributes', function ($query) use ($ids, $values) {
            $query->whereIn('attributes.id', $ids);
            $query->whereIn('value', $values);
        });


        $products = $products->limit($limit)->get();


        return response()->json(new PorductShortCollection($products));
    }
}
