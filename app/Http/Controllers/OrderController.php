<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Book;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductsOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function createOrder(Request $request)
    {

        if (isset($request->uuId)) {
            $userId = $request->uuId;
        } else {
            $userId = Auth::user()->id;
        }

        \Cart::session($userId);
        $carts = \Cart::getContent();
        $total = 0;
        $userId = Auth::user()->id;
        $addressId = 0;
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
        $order->note = $request->note ?? null;
        $order->city = $request->city ?? 'Moskva';

//        if (gettype($request->address_id) === "integer") {
//            $order->address_id = $request->address_id ?? 1;
//            $addressId = $request->address_id ?? 1;
//        } else {
//            $address = Address::create([
//                'name' => $request->address_id['name'],
//                'lastName' => $request->address_id['lastName'],
//                'fatherName' => $request->address_id['fatherName'],
//                "phone" => $request->address_id['phone'],
//                "email" => $request->address_id['email'],
//                'user_id' => $userId,
//                "company" => $request->address_id['company'] ?? null,
//                "address_1" => $request->address_id['address_1'],
//                "address_2" => $request->address_id['address_2'],
//                "city" => $request->address_id['city'],
//                "country" => $request->address_id['country'],
//                "region" => $request->address_id['region'],
//                "post" => $request->address_id['post'],
//            ]);
//            $addressId = $address->id;
//        }

        $order->status = 1;
        $order->save();
//
//
//        $order->address_id = $addressId;
//        $order->update();
        foreach ($carts as $cart) {
            $productsOrder = new ProductsOrder();
            $productsOrder->product_id = $cart->id;
            $productsOrder->order_id = $order->id;
            $productsOrder->quantity = $cart->quantity;
            $productsOrder->price = $cart->price;
            $productsOrder->save();
            \Cart::session($userId)->remove($cart->id);
        }


        $orderData = Order::with('products.item', 'user', 'address')->find($order->id);

        $content = [
            'subject' => 'Заказ N ' . $order->id,
            'body' => $order
        ];


        Mail::to(Auth::user()->email)->send(new OrderMail($content));

        return response()->json([
            "status" => 200,
        ]);
    }


    public function preOrder($id)
    {
        $userId = Auth::user()->id;
        $product = Product::find($id);
        $price = 0;
        $addressId = 1;
        if (!isset($product)) {
            return response()->json([
                'message' => 'not found',
                'success' => 0
            ]);
        }
        //// $price = round(($product->price * 10) / 100);
        $order = new Order();
        $order->total = 0;
        $order->user_id = $userId;
        $order->delivery = 0;
        $order->grant_total = 0;
//        $order->note = $request->note ?? null;
//        $order->city = $request->city ?? 'Moskva';
//        dd(gettype($request->address_id));
//        if (gettype($request->address_id) === "integer") {
//            $order->address_id = $request->address_id ?? 1;
//            $addressId = $request->address_id ?? 1;
//        } else {
//            $address = Address::create([
//                'name' => $request->address_id['name'],
//                'lastName' => $request->address_id['lastName'],
//                'fatherName' => $request->address_id['fatherName'],
//                "phone" => $request->address_id['phone'],
//                "email" => $request->address_id['email'],
//                'user_id' => $userId,
//                "company" => $request->address_id['company'] ?? null,
//                "address_1" => $request->address_id['address_1'],
//                "address_2" => $request->address_id['address_2'],
//                "city" => $request->address_id['city'],
//                "country" => $request->address_id['country'],
//                "region" => $request->address_id['region'],
//                "post" => $request->address_id['post'],
//            ]);
//            $addressId = $address->id;
//        }if (gettype($request->address_id) === "integer") {
//            $order->address_id = $request->address_id ?? 1;
//            $addressId = $request->address_id ?? 1;
//        } else {
//            $address = Address::create([
//                'name' => $request->address_id['name'],
//                'lastName' => $request->address_id['lastName'],
//                'fatherName' => $request->address_id['fatherName'],
//                "phone" => $request->address_id['phone'],
//                "email" => $request->address_id['email'],
//                'user_id' => $userId,
//                "company" => $request->address_id['company'] ?? null,
//                "address_1" => $request->address_id['address_1'],
//                "address_2" => $request->address_id['address_2'],
//                "city" => $request->address_id['city'],
//                "country" => $request->address_id['country'],
//                "region" => $request->address_id['region'],
//                "post" => $request->address_id['post'],
//            ]);
//            $addressId = $address->id;
//        }
        $order->status = 2;
        $order->save();
//        $order->address_id = $addressId;
        ///  $order->update();
        $productsOrder = new ProductsOrder();
        $productsOrder->product_id = $product->id;
        $productsOrder->order_id = $order->id;
        $productsOrder->quantity = 1;
        $productsOrder->price = $price;
        $productsOrder->save();

        $book = new Book();
        $book->user_id = $userId;
        $book->product_id = $product->id;
        $book->save();

        $orderData = Order::with('products.item', 'user', 'address')->find($order->id);

        $content = [
            'subject' => 'Предзаказ N ' . $order->id,
            'body' => $orderData
        ];

        Mail::to(Auth::user()->email)->send(new OrderMail($content));

        return response()->json([
            "status" => 200,
        ]);

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
