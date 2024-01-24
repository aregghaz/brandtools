<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public int $user = 1;
    public function __construct()
    {
        \Cart::session($this->user);
    }

    public function index($productId,$qty)
    {
         $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        $rowId = 456; // generate a unique() row ID
        $userID = 2; // the user ID to bind the cart contents

// add the product to cart
        $asd = \Cart::add(array(
            'id' => 18, // inique row ID
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $qty,
//            'attributes' => array()
        ));

        return $asd;
    }

//
    public function getCart()
    {
        $asd = \Cart::getContent();

        return $asd;
    }
    public function update()
    {
        \Cart::update(13, array(
            'name' => 'New Item Name', // new item name
            'quantity' => array(
                'relative' => false,
                'value' => 5
            ),
        ));
        $asd = \Cart::getContent();

        return $asd;
    }
}
