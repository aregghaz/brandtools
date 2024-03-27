<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MonthOrderStatusCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *

     */
    public function toArray(Request $request)
    {
        return $this->map(function ($data) {


            return [
                'month' => $data['month'],
                'status' => (int)$data['status'],
                'count' => $data['count'],
            ];
        });
    }
}
