<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;

class NoAuthController extends Controller
{
    public $uuid = false;


    public function index(Request $request,$productId, $qty)
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        if(!$request->uuid){
            $uniqid = Str::random(9);
            $this->uuid = $uniqid;

        }else{
            $this->uuid = $request->uuid;
        }
        \Cart::session($this->uuid)->add(array(
            'id' => $Product->id, // inique row ID
            'name' => $Product->name,
            'image' => $Product->image,
            'price' => $Product->price,
            'quantity' => $qty,
        ));

        $cart = \Cart::getContent();
        return response()->json([
            'cart'=>$cart,
             'uuid'=>$this->uuid
        ]);

    }

//
    public function getCart(Request $request)
    {

        if(!$request->uuid){
            $uniqid = Str::random(9);
            $this->uuid = $uniqid;

        }else{
            $this->uuid = $request->uuid;
        }

        $cart = \Cart::session($this->uuid)->getContent();
        return response()->json([
            'cart'=>$cart,
            'uuid'=>$this->uuid
        ]);

    }

    public function update(Request $request,$productId, $qty): \Illuminate\Http\JsonResponse
    {
        if(!$request->uuid){
            $uniqid = Str::random(9);
            $this->uuid = $uniqid;

        }else{
            $this->uuid = $request->uuid;
        }
        \Cart::session($this->uuid)->update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => $qty
            ),
        ));
        $cart = \Cart::getContent();

        return response()->json([
            'cart'=>$cart,
            'uuid'=>$this->uuid
        ]);
    }

    public function delete(Request $request,$productId)
    {
        if(!$request->uuid){
            $uniqid = Str::random(9);
            $this->uuid = $uniqid;

        }else{
            $this->uuid = $request->uuid;
        }
        \Cart::session($this->uuid)->remove($productId);
        $cart = \Cart::getContent();
        return response()->json([
            'cart'=>$cart,
            'uuid'=>$this->uuid
        ]);

    }
}
