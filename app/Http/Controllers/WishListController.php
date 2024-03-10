<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;

class WishListController extends Controller
{


    public $uuid = false;


    public function index(Request $request,$productId, $qty)
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        if(!$request->session()->has('_uuid')){
            $uniqid = Str::random(9);
            $request->session()->put('_uuid', $uniqid);
            $this->uuid = $uniqid;
        }else{
            $this->uuid = $request->session()->get('_uuid');
        }
        if (!isset($Product)) {
            return response()->json([
                "message" => 'product not found'
            ]);
        }
        \Cart::session($this->uuid)->add(array(
            'id' => $Product->id, // inique row ID
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $qty,
        ));
        $cart = \Cart::getContent();
        return response()->json($cart);

    }

//
    public function getCart(Request $request)
    {
        if(!$request->session()->has('_uuid')){
            $uniqid = Str::random(9);
            $request->session()->put('_uuid', $uniqid);
            $this->uuid = $uniqid;
        }else{
            $this->uuid = $request->session()->get('_uuid');
        }
        $cart = \Cart::session($this->uuid)->getContent();
        return response()->json($cart);

    }

    public function update(Request $request,$productId, $qty): \Illuminate\Http\JsonResponse
    {
        if(!$request->session()->has('_uuid')){
            $uniqid = Str::random(9);
            $request->session()->put('_uuid', $uniqid);
            $this->uuid = $uniqid;
        }else{
            $this->uuid = $request->session()->get('_uuid');
        }
        \Cart::session($this->uuid)->update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => $qty
            ),
        ));
        $cart = \Cart::getContent();

        return response()->json($cart);
    }

    public function delete(Request $request,$productId)
    {
        if(!$request->session()->has('_uuid')){
            $uniqid = Str::random(9);
            $request->session()->put('_uuid', $uniqid);
            $this->uuid = $uniqid;
        }else{
            $this->uuid = $request->session()->get('_uuid');
        }
        \Cart::session($this->uuid)->remove($productId);
        $cart = \Cart::getContent();
        return response()->json($cart);

    }
//    public function index(Request $request)
//    {
//
//
//
//
//        if(!$request->session()->has('_uuid')){
//            $uniqid = Str::random(9);
//            $request->session()->put('_uuid', $uniqid);
//        }
//        $uuid = $request->session()->get('_uuid');
//      //  dd($uuid,$request->session()->has('_uuid'));
//        $items = [];
//        $wish_list = app('wishlist');
//
//        $wish_list->getContent()->each(function($item) use (&$items)
//        {
//            $items[] = $item;
//        });
//
//        return response(array(
//            'success' => true,
//            'data' => $items,
//            'uuid' => $uuid,
//            'message' => 'wishlist get items success'
//        ),200,[]);
//    }
//
//    public function add(Request $request)
//    {
//        $wish_list = app('wishlist');
//        $id = request('id');
//        $Product = Product::find($id); // assuming you have a Product model with id, name, description & price
//        $uuid = $request->session()->get('_uuid');
//       // dd($uuid,$request->session()->has('_uuid'));
//        if (!isset($Product)) {
//            return response()->json([
//                "message" => 'product not found'
//            ]);
//        }
//
////dd($Product);
//        $wish_list->add($id, $Product->name, $Product->price,1, array());
//
//        return response(array(
//            'success' => true,
//            'uuid' => $uuid,
//            'message' => 'wishlist add items success'
//        ),200,[]);
//    }
//
//    public function delete($id)
//    {
//        $wish_list = app('wishlist');
//
//        $wish_list->remove($id);
//
//        return response(array(
//            'success' => true,
//            'data' => $id,
//            'message' => "cart item {$id} removed."
//        ),200,[]);
//    }
//
//    public function details(Request $request)
//    {
//        $wish_list = app('wishlist');
//        $uuid = $request->session()->get('_uuid');
//        return response(array(
//            'success' => true,
//            'uuid' => $uuid,
//            'data' => array(
//                'total_quantity' => $wish_list->getTotalQuantity(),
//                'sub_total' => $wish_list->getSubTotal(),
//                'total' => $wish_list->getTotal(),
//            ),
//            'message' => "Get wishlist details success."
//        ),200,[]);
//    }
}
