<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoAuthController extends Controller
{

    public function index($productId, $qty)
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price

        if (!isset($Product)) {
            return response()->json([
                "message" => 'product not found'
            ]);
        }
        \Cart::add(array(
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
        $cart = \Cart::getContent();
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
