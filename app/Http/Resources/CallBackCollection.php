<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CallBackCollection extends ResourceCollection
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
                'email' => $data->email,
                'phone' => $data->phone,
                "updated"=> $data->updated_at,
            ];
        });
    }
}
