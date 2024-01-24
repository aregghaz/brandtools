<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json(new BrandCollection($brands));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $brand = Brand::create([
            "title" => $data->title
        ]);
        return response()->json([
            "status" => 200,
            'data'=>$brand
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json([
            "data"=> [
                'id' =>$brand->id,
                'title' =>$brand->title,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand, Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $brand->update([
            'title'=>$data->title,
        ]);
        return response()->json([
            "status" => 200,
            'data'=>$brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            "status" => 200,
        ]);
    }
}
