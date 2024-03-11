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
//        $attrIds = array_keys((array)$filt);
//        $ids = [];
        foreach ($filt as $key => $attribute) {
            $ids[] = key((array)$attribute);
            /// var_dump(key((array)$attribute));
        }
        ///  $attrIds2 = DB::table('products');
        //   ->where('status', 1);

//        $attrIds2 = $attrIds2->leftJoin('product_attribute', 'product_attribute.product_id', '=', 'products.id');
//        $attrIds2 = $attrIds2->leftJoin('category_product', 'category_product.product_id', '=', 'products.id');
//        $attrIds2 = $attrIds2->where('category_product.category_id' , $id);
//             // foreach ($attrIds as $id) {
//                  $attrIds2 = $attrIds2->whereIn('product_attribute.attribute_id', $attrIds);
//              //}
////            ->whereIn('attribute_id', $attrIds)
//            $attrIds2 = $attrIds2->limit(2)
//                ->get();
//        dd($attrIds2);
//        foreach ($ids as $idss) {
//         //   dd(key((array)$ids));
//            $conditions[] = ['attributes.id', '=', $idss];
//        }
//        //$products = Product::whereHas('categories');
//
//        $products = Product::whereHas('attributes', function ($q) use ($conditions) {
//         //   dd($conditions);
//            $q->where($conditions);
//        });
//
//        $products = $products->limit(2)->get();
//        dd($products);
//        $products = Product::query();
//
//        // Filter products based on selected attribute values
//       // if (true) {
//            $products->where('status',1)->whereHas('categories', function($q)use ($id){
//                $q->where('categories.id', $id);
//            });
//            foreach ($filt as $attributeId) {
//
//                $attrid = key((array)$attributeId);
//                $atttrValue = $attributeId[key((array)$attributeId)];
//                $products->whereHas('attributes', function ($query) use ($attrid, $atttrValue) {
//                    $query->where('attributes.id', $attrid)->where('value', $atttrValue);
//                });
//            }
//        //}      die;

        ///   $products = $products->limit($limit)->get();


//        $products = Product::whereHas('attributes');
//        $products =  $products->where('status',1)->whereHas('categories', function($q)use ($id){
//                $q->where('categories.id', $id);
//            });
//        // Filter products based on selected attribute values
//        if (true) {
//            foreach ($filt as $attributeId) {
//
//                $attrid = key((array)$attributeId);
//                $atttrValue = $attributeId[key((array)$attributeId)];
//                $products->whereHas('attributes', function ($query) use ($attrid, $atttrValue) {
//                    $query->where('attributes.id', $attrid)->where('value', $atttrValue);
//                });
//            }
//        }
//
//        $products = $products->limit($limit)->get();
        $products = Product::whereHas(['attributes' => function ($query) use ($request, $filt) {
            // Filter attributes based on selected values
            foreach ($filt as $attributeId) {
                $attrid = key((array)$attributeId);
                $atttrValue = $attributeId[key((array)$attributeId)];
                $query->where('attributes.id', $attrid)->where('value', $atttrValue);
            }
        }])->limit($limit)->get();

        return response()->json(new PorductShortCollection($products));
    }
}
