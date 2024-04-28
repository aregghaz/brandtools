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
        return $data->where(function ($query) use ($queryData, $type) {
            $query->where($type === 1 ? 'name' : "title", 'LIKE', '%' . $queryData . '%');
            if ($type !== 3) {
                $query->orWhere('slug', 'LIKE', '%' . $queryData . '%');
            }
//            if ($type === 1) {
//                ///var_dump($queryData,'11');
//                $query->orWhereHas('categories', function ($q) use ($queryData) {
//                    $q->where('title', 'LIKE', '%' . $queryData. '%');
//
//                });
//            }

        });
    }

    protected function convertUserQuery($queryData, $data)
    {
        return $data->where(function ($query) use ($queryData) {
            $query->where('name', 'LIKE', '%' . $queryData . '%')
                ->orWhere('lastName', 'LIKE', '%' . $queryData . '%')
                ->orWhere('email', 'LIKE', '%' . $queryData . '%')
                ->orWhere('phone', 'LIKE', '%' . $queryData . '%');

        });
    }

    protected function orderQuery($queryData, $data)
    {

        return $data->where(function ($query) use ($queryData) {
            $query->whereHas('products.item', function ($q) use ($queryData) {
                $q->where('name', 'LIKE', '%' . $queryData . '%');
            })->orWhereHas('user', function ($q) use ($queryData) {
                $q->where('name', 'LIKE', '%' . $queryData . '%');
            });
            $query->orWhere('grant_total', 'LIKE', '%' . $queryData . '%');
        });
    }

    public function simpleSelect(): array
    {
        return [
            (object)[
                "id" => 1,
                "title" => "включено"
            ],
            (object)[
                "id" => 2,
                "title" => "отключить"
            ]
        ];
    }
}
