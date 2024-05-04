<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannersCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::all();
        return response()->json(new BannersCollection($banner));
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
    public function show(Banner $banner)
    {
        $position = [
            (object)[
                "id" => 1,
                "title" => 1
            ],
            (object)[
                "id" => 2,
                "title" => 2
            ]
        ];
        return response()->json([
            'data' => [
                'id' => $banner->id,
                'image' => url($banner->image),
                'position' => [
                    "id" => $banner->position,
                    "value" => $banner->position,
                    "label" => $banner->position,
                    "name" => $banner->position,
                ],
                "updated" => $banner->updated_at,
            ],
            'position' => new SelectCollection($position)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);

        $banner->update([
            'image' => '/storage/'.explode("storage", $data->image)[1],
            'position' => $data->position->id,
        ]);
        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
