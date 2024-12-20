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
        $price = 0;
        if($Product->end > date('Y-m-d') and $Product->special_price > 0){
            $price = $Product->special_price;
        }else{
            $price = $Product->price;
        }

        \Cart::session(Auth::user()->id)->add(array(
            'id' => $Product->id, // inique row ID
            'name' => $Product->name,
            'price' => $price,
            'attributes' => array(
                'image' => $Product->image,
                'slug'=>$Product->slug
            ),
            'conditions' => array(
                'quantity' => $Product->quantity,
            ),
            'associatedModel' => $Product,
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
        \Cart::session(Auth::user()->id)->update($productId, array(
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
        \Cart::session(Auth::user()->id)->remove($productId);
        $cart = \Cart::getContent();
        return response()->json($cart);

    }
}
