<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectCollection;
use App\Http\Resources\VideoCollection;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $showMore = $request->get('showMore');
        $queryData = $request->get('query');

        $video = Video::orderBy('id', 'DESC');
        if (isset($queryData)) {
            $this->convertQuery($queryData, $video, 2);
        }
        $video = $video->take(15 * $showMore)->get();
        return response()->json(new VideoCollection($video));

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

        Video::create([
            'title' => $data->title,
            'video' => $data->video ?? null,
            'status' => 1,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {

        return response()->json([
            'status' => new SelectCollection($this->simpleSelect()),
            "data" => [
                'id' => $video->id,
                'title' => $video->title,
                'status' => [
                    "id" => $video->status,
                    "value" => $video->status,
                    "label" => $video->status === 1 ? 'включено' : 'отключить',
                    "name" => $video->status === 1 ? 'включено' : 'отключить',
                ],
                'video' => $video->video,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);

        $video->update([
            'title' => $data->title,
            'video' => $data->video ?? null,
            'status' => $data->status->id,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json([
            "status" => 200,
        ]);
    }
}
