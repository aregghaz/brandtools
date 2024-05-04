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

}
