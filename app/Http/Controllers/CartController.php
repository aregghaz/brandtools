<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function __construct()
    {
        \Cart::session(3);
    }

    public function index()
    {
         $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        $rowId = 456; // generate a unique() row ID
        $userID = 2; // the user ID to bind the cart contents

// add the product to cart
        $asd = \Cart::add(array(
            'id' => 18, // inique row ID
            'name' => 'Sample Item 3',
            'price' => 67.99,
            'quantity' => 4,
            'attributes' => array()
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
