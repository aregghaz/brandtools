<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function convertQuery($queryData, $data, $type)
    {

        $data = $data->where(function ($query) use ($queryData, $type) {
            $query->where($type === 1 ? 'name' : "title", 'LIKE', '%' . $queryData . '%');
            if ($type !== 3) {
                $query->orWhere('slug', 'LIKE', '%' . $queryData . '%');
            }

//                ->orWhere('id', 'LIKE', '%' . $queryData . '%');
        });

        return $data;
    }
}
