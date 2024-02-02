<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\SelectCollection;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $showMore = $request->get('showMore');
        $queryData = $request->get('query');

        $news = News::orderBy('id', 'DESC');
        if (isset($queryData)) {
            $this->convertQuery($queryData, $news, 2);
        }
        $news = $news->take(15 * $showMore)->get();
        return response()->json(new NewsCollection($news));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
        $storageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/news", $file);
            $storageName = "/storage/images/news/" . basename($storagePath);
        }
        News::create([
            'title' => $data->title,
            'image' => $storageName ?? null,
            'video' => $data->video ?? null,
            'content' => $data->content,
            'status' => 1,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $status = [
            (object)[
                "id" => 1,
                "title" => "enable"
            ],
            (object)[
                "id" => 2,
                "title" => "disable"
            ]
        ];

        return response()->json([
            'status' => new SelectCollection($status),
            "data" => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'status' => [
                    "id" => $news->status,
                    "value" => $news->status,
                    "label" => $news->status === 1 ? 'enable' : 'disable',
                    "name" => $news->status === 1 ? 'enable' : 'disable',
                ],
                'video' => $news->video,
                'meta_title' => $news->meta_title,
                'meta_desc' => $news->meta_desc,
                'meta_key' => $news->meta_key,

            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'value' => 'required',
        ]);
        $data = json_decode($request->value);
        $storageName = null;
        if ($request->hasFile('image')) {
            $imageFile = explode('/', $news->image);
            Storage::delete("public/images/news/" . $imageFile[count($imageFile) - 1]);
            $file = $request->file('image');
            $storagePath = Storage::put("public/images/news/", $file);
            $storageName = "/storage/images/news/" . basename($storagePath);
            $news->update([
                'image' => $storageName,
            ]);

        }
        $news->update([
            'title' => $data->title,
            'video' => $data->video ?? null,
            'content' => $data->content,
            'status' => $data->status->id,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();
        return response()->json([
            "status" => 200,
        ]);

    }
}
