<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    /////FIXME SHOUD FIX CART SESSSION PART
    public function __construct()
    {

        if (Auth::check()) {
            \Cart::session(Auth::user()->id);
        }
    }

    public function index($productId, $qty)
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price

        if (!isset($Product)) {
            return response()->json([
                "message" => 'product not found'
            ]);
        }
        \Cart::session(Auth::user()->id)->add(array(
            'id' => $Product->id, // inique row ID
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $qty,
        ));
        $cart = \Cart::getContent();
        return response()->json($cart);

    }

//
    public function getCart()
    {
        $cart = \Cart::session(Auth::user()->id)->getContent();
        return response()->json($cart);

    }

    public function update($productId, $qty)
    {
        \Cart::update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => $qty
            ),
        ));
        $cart = \Cart::getContent();

        return response()->json($cart);
    }

    public function delete($productId)
    {
        \Cart::remove($productId);
        $cart = \Cart::getContent();
        return response()->json($cart);

    }
}
