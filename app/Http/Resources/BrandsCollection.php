<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($data) {
            return [
                'id' => $data->id,
                'title' => $data->title,
                'slug' => $data->slug,
                'meta_title'=>$data->meta_title?? '--',
                'meta_desc'=>$data->meta_desc?? '--',
                'meta_key'=>$data->meta_key?? '--',
                'status'=>$data->status?? '--',
                'image'=>$data->image?? null,
                "updated"=> $data->updated_at,
            ];
        });
    }
}
