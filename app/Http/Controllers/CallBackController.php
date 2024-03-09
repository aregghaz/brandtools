<?php

namespace App\Http\Controllers;

use App\Models\CallBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CallBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CallBack::orderBy('id', 'DESC')->get();
        return response()->json($data);
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
        }
        CallBack::create([
            'email'=> $request->email,
            'phone'=> $request->phone,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CallBack $callBack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallBack $callBack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallBack $callBack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallBack $callBack)
    {
        //
    }
}
