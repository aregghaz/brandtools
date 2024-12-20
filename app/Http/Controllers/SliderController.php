<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectCollection;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        return response()->json($sliders);
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
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);

        Slider::create([
            'image' => '/storage/' . explode("storage", $data->image)[1],
            'position' => $data->position->id ?? 1,
            'status' => 1,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return response()->json([
            'status' => new SelectCollection($this->simpleSelect()),
            'data' => [
                'id' => $slider->id,
                'image' => url($slider->image),
                'position' => $slider->position,
                'status' => [
                    "id" => $slider->status,
                    "value" => $slider->status,
                    "label" => $slider->status === 1 ? 'включено' : 'отключить',
                    "name" => $slider->status === 1 ? 'включено' : 'отключить',
                ],
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);

        $slider->update([
            'image' => '/storage/' . explode("storage", $data->image)[1],
            "position" => $data->position,
            "status" => $data->status->id,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return response()->json([
            "status" => 200,
        ]);
    }
}
