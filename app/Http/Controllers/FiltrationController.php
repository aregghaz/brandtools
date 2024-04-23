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
        $sortId = $request->sort_id;
        $values = [];
        $checkPrice = false;
        $checkBrand = false;
        $brandId = 0;
        $priceValue = [];
        if (isset($filt)) {
            foreach ($filt as $attribute) {
                if (key((array)$attribute) !== 9999 and key((array)$attribute) !== 99999  ) {
                    $ids[] = key((array)$attribute);
                    $values[] = value((array)$attribute);
                } else if(key((array)$attribute) == 9999) {
                    $checkPrice = true;
                    $priceValue = value((array)$attribute);
                } else if(key((array)$attribute) == 99999) {
                    $checkBrand = true;
                    $brandId = value((array)$attribute);
                }
            }
        }


        $products = Product::where('status', 1)
            ->with(['attributes', 'categories' => function ($q) use ($id) {
                $q->where('categories.id', $id);
            }]);
        if ($checkPrice) {
            $products = $products->whereBetween('price', [value((array)$priceValue)[9999][0], value((array)$priceValue)[9999][1]]);
        }
        if ($checkBrand and $brandId !== 0) {
            $products = $products->where('brand_id', $brandId);
        }
        if (isset($sortId)) {
            $products = $products->where('teg_id',$sortId );

        }

        if (count($values) > 0) {
            $products = $products->whereHas('attributes', function ($query) use ($ids, $values) {
                $query->whereIn('attributes.id', $ids);
                $query->whereIn('value', $values);
            });

        }


        $products = $products->limit($limit)->get();


        return response()->json(new PorductShortCollection($products));
    }
}
