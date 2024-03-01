<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($data) {
            $categoryName = '';
            foreach ($data->categories as $item){
                $categoryName .= $item->title .", " . $categoryName;
            }
           // $images = explode('.JPG' ,$data->image);
            return [
                'id' => $data->id,
                "image" => $data->image,
                'name' => $data->name,
                'price' => $data->price,
                "special_price" => $data->special_price,
                "slug" => $data->slug,
                "teg" => $data->teg ? $data->teg->title : '--',
                "brand" => $data->brand->title ?? '--',
                "categories" =>$categoryName,
               /// 'status'=>$data->status,
               /// 'description' => $data->description ,
                "updated" => $data->updated_at,
            ];
        });
    }
}
