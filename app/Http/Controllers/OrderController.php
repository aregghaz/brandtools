<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\ProductsOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Math\PrimeField\Integer;

class OrderController extends Controller
{

    public function createOrder(Request $request)
    {

        $userId = Auth::user()->id;
        \Cart::session($userId);
        $carts = \Cart::getContent();
        $total = 0;
        if (!count($carts)) {
            return response()->json([
                'message' => 'no item in cart',
                'success' => 0
            ]);
        }
        foreach ($carts as $cart) {
            $total = $total + $cart->price;
        }
        $order = new Order();
        $order->total = $total;
        $order->user_id = $userId;
        $order->delivery = $request->delivery ?? 0;
        $order->grant_total = $total + ($request->delivery ?? 0);
        $order->note = $request->note ?? '';
        if(gettype($request->address_id) === "Integer"){
            $order->address_id = $request->address_id ?? 1;
        }

        $order->status = 1;
        $order->save();
        Address::create([
            'name' => $request->address_id->name,
            'lastName' => $request->address_id->lastName,
            'fatherName' => $request->address_id->fatherName,
            "phone" => $request->address_id->phone,
            "email" => $request->address_id->email,
            'user_id'=>$order->address_id->id,
            "company" => $request->address_id->company ?? null,
            "address_1" => $request->address_id->address_1,
            "address_2" => $request->address_id->address_2,
            "city" => $request->address_id->city,
            "country" => $request->address_id->country,
            "region" => $request->address_id->region,
            "post" => $request->address_id->post,
        ]);
        foreach ($carts as $cart) {
            $productsOrder = new ProductsOrder();
            $productsOrder->product_id = $cart->id;
            $productsOrder->order_id = $order->id;
            $productsOrder->quantity = $cart->quantity;
            $productsOrder->price = $cart->price;
            $productsOrder->save();
            \Cart::session($userId)->remove($cart->id);
        }
        return 1;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
