<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        /* open this for local file testing purposes only*/


        /// DB::beginTransaction();

        ///  $vendorId = $request->user()->vendor_id;
        $csv_data = file_get_contents(base_path() . '/public/uploads/1.xlsx');

        // $path = $request->file('file');
        // $csv_data = file_get_contents($path);
        /// $data = \Excel::load($path)->get();
        $rows = str_getcsv($csv_data, "\n");

        $result = array();
        foreach ($rows as $k => $row) {
            if ($k > 0) {

                $result[$k - 1] = str_getcsv($rows[$k], ',');
            }
        }
        dd($result);
        foreach ($result as $data => $index) {
            // $data = explode(",", $data[0]);
            dd($rows);
            $category_id = 0;
            $parent_id = 1;
            $name = 2;
            $image = 6;
            $description = 9;
            $meta_title = 10;
            $meta_desc = 11;
            $meta_key = 12;
            $status = 15;

//
//            //////Request Type
//            $requestTypeId = 0;
//            $checkRequestType = RequestType::where('name', $data[$request_type])->first();
//            if (isset($checkRequestType)) {
//                $requestTypeId = $checkRequestType->id;
//            } else {
//                $dataCreateRequest = RequestType::create([
//                    'name' => $data[$request_type],
//                    "slug" => $data[$request_type]
//                ]);
//                $requestTypeId = $dataCreateRequest->id;
//            }
dd($data);
            $categoryData = Category::create([
                "title" => $data[$name],
                ///'parent_id'=>$parent_id,
                'category_id' => $data[$category_id],
                'description' => $data[$description],
                'meta_title' => $data[$meta_title],
                'meta_desc' => $data[$meta_desc],
                'meta_key' => $data[$meta_key],
                'status' => $data[$status],
                'image' => $data[$image],
            ]);
        }
        return true;
    }

}
