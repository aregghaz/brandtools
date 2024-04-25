<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubscriptionCollection;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data = Subscription::all();
        return response()->json(new SubscriptionCollection($data));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($email)
    {
        $subscription = Subscription::create([
            "email" => $email,
            'status'=>1
        ]);
        return response()->json([
            'status' => 200
        ]);
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
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
