<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $conditions = Condition::all();
        return response()->json(new BrandCollection($conditions));
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
        $condition = Condition::create([
            "title" => $data->title,
        ]);

        return response()->json($condition);
    }

    /**
     * Display the specified resource.
     */
    public function show(Condition $condition)
    {
        return response()->json([
            "data"=> [
                'id' =>$condition->id,
                'title' =>$condition->title,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condition $condition)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $condition->update([
            'title'=>$data->title,
        ]);
        return response()->json([
            "status" => 200,
            'data'=>$condition
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condition $condition)
    {
        $condition->delete();
        return response()->json([
            'status' => 200
        ]);
    }
}
