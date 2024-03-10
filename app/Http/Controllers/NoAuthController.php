<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoAuthController extends Controller
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
}
