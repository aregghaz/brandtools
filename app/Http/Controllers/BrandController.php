<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollection;
use App\Http\Resources\SelectCollection;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showMore = $request->get('showMore');
        $brands = Brand::orderBy('id', 'DESC');
        $queryData = $request->get('query');
        if (isset($queryData)) {
            $this->convertQuery($queryData, $brands, 2);
        }
        $brands = $brands->take(15 * $showMore)->orderBy('id', 'DESC')->get();
        return response()->json(new BrandCollection($brands));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'top' => new SelectCollection($this->simpleSelect()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'image' => 'file',
        ]);
        $data = json_decode($request->value);

        $storageName = null;
//        if ($request->hasFile('image')) {
//            $file = $request->file('image');
//            $storagePath = Storage::put("public/images/brands", $file);
//            $storageName = "/storage/images/brands/" . basename($storagePath);
//        }
        $brand = Brand::create([
            'title' => $data->title,
            'image' => '/storage/'.explode("storage", $data->image)[1],
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'top' => $data->top->id ?? 0,
            'meta_desc' => $data->meta_desc ?? '',
            'meta_key' => $data->meta_key ?? '',
        ]);
        return response()->json([
            "status" => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json([
            'top' => new SelectCollection($this->simpleSelect()),
            "data" => [
                'id' => $brand->id,
                'title' => $brand->title,
                'description' => $brand->description,
                'meta_title' => $brand->meta_title,
                'meta_desc' => $brand->meta_desc,
                'meta_key' => $brand->meta_key,
                'top' => [
                    "id" => $brand->top,
                    "value" => $brand->top,
                    "label" => $brand->top === 1 ? 'включено' : 'отключить',
                    "name" => $brand->top === 1 ? 'включено' : 'отключить',
                ],
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
        $storageName = null;
//        if ($request->hasFile('image')) {
//            $imageFile = explode('/', $brand->image);
//            Storage::delete("public/images/brands/" . $imageFile[count($imageFile) - 1]);
//            $file = $request->file('image');
//            $storagePath = Storage::put("public/images/brands", $file);
//            $storageName = "/storage/images/brands/" . basename($storagePath);
//            $brand->update([
//                'image' => $storageName,
//            ]);
//        }
        $brand->update([
            'title' => $data->title,
            'image' => '/storage/'.explode("storage", $data->image)[1],
            'description' => $data->description,
            'meta_title' => $data->meta_title,
            'meta_desc' => $data->meta_desc,
            'meta_key' => $data->meta_key,
            'top' => $data->top->id ?? 0,
        ]);
        return response()->json([
            "status" => 200,
            'data' => $brand
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $imageFile = explode('/', $brand->image);
      ///  Storage::delete("public/images/brands/" . $imageFile[count($imageFile) - 1]);
        $brand->delete();
        return response()->json([
            "status" => 200,
        ]);
    }
}
