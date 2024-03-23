<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectCollection;
use App\Http\Resources\TagsCollection;
use App\Models\Product;
use App\Models\Teg;
use Illuminate\Http\Request;

class TegController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Teg::all();
        return response()->json(new TagsCollection($tags));
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
        $teg = new Teg();
        $teg->title = $data->title;
        $teg->position = $data->position;
        $teg->save();
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teg $teg, $id)
    {

        $teg = Teg::find($id);
        return response()->json([
//            'status' => new SelectCollection($this->simpleSelect()),
            'data' => [
                'id' => $teg->id,
                'title' => $teg->title,
                'position' => $teg->position,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teg $teg, Request $request,)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        Teg::find($id)->update([
            'title' => $data->title,
            'position' => (int)$data->position,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teg $teg, $id)
    {
        Teg::find($id)->delete();
        return response()->json([
            "status" => 200,
        ]);
    }


    public function getTagsSelect()
    {
        $tags = Teg::all();
        return response()->json([
            "data" => new SelectCollection($tags),
            "status" => 200,
        ]);
    }
    public function addTags(Request $request): \Illuminate\Http\JsonResponse
    {

        Product::whereIn('id', $request->ids)->update(['teg_id'=> $request->tegId]);
        return response()->json([
            "status" => 200,
        ]);
    }
}
