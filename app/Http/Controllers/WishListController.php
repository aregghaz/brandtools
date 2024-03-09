<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index()
    {
        $items = [];
        $wish_list = app('wishlist');

        $wish_list->getContent()->each(function($item) use (&$items)
        {
            $items[] = $item;
        });

        return response(array(
            'success' => true,
            'data' => $items,
            'message' => 'wishlist get items success'
        ),200,[]);
    }

    public function add()
    {
        $wish_list = app('wishlist');
        $id = request('id');
        $Product = Product::find($id); // assuming you have a Product model with id, name, description & price

        if (!isset($Product)) {
            return response()->json([
                "message" => 'product not found'
            ]);
        }

//dd($Product);
        $wish_list->add($id, $Product->name, $Product->price,1, array());

        return response(array(
            'success' => true,
            'message' => 'wishlist add items success'
        ),200,[]);
    }

    public function delete($id)
    {
        $wish_list = app('wishlist');

        $wish_list->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ),200,[]);
    }

    public function details()
    {
        $wish_list = app('wishlist');

        return response(array(
            'success' => true,
            'data' => array(
                'total_quantity' => $wish_list->getTotalQuantity(),
                'sub_total' => $wish_list->getSubTotal(),
                'total' => $wish_list->getTotal(),
            ),
            'message' => "Get wishlist details success."
        ),200,[]);
    }
}
