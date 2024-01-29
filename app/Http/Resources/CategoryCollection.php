<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
                'image' => $data->image,
                'title' => $data->title,
                'slug' => $data->slug,
                'parent' => $data->parent_id ? $data->parent->title : '--',
                "updated"=> $data->updated_at,
              ///  'description'=>$data->description?? '--',
                'meta_title'=>$data->meta_title?? '--',
               /// 'meta_desc'=>$data->meta_desc?? '--',
                'meta_key'=>$data->meta_key?? '--',
                'status'=>$data->status?? '--',


            ];
        });
    }
}
