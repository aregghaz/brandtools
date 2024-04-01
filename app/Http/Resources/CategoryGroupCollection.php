<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use stdClass;

class CategoryGroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     */
    public function toArray(Request $request)
    {
        return $this->map(function ($category) {
            $users = [];

            $users = $this->getChildren($category);
            return [
                "label" => $category->title,
                "value" => [[
                    'label'=> $category->title,
                    'id'=> $category->id,
                    'value'=> $category->title,
                ]],
                "options" => $users,

            ];
        });

    }

    public function getChildren($category)
    {

        $cat = [];
        $ids = [];
        if (count($category->children)) {

            for ($i = 0; $i < count($category->children); $i++) {
                $object = new stdClass();
                $object->label = $category->children[$i]->title;
                $object->value = $category->children[$i]->id;
                $object->id = $category->children[$i]->id;
                $ids[] = $category->children[$i]->id;
                if (isset($category->children[$i]->children) and count($category->children[$i]->children)) {
                    $childrenItem = $category->children[$i];
                    $object->option = $this->getChildren($childrenItem);
                }
                $cat[] = $object;
            }
        }
        return $cat;
    }
}
