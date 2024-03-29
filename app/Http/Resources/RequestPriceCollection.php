<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RequestPriceCollection extends ResourceCollection
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
                'name' => $data->name,
                'lastName' => $data->lastName,
                "phone" => $data->phone,
                "email" => $data->email,
                'company'=>$data->company,
            ];
        });
    }
}
