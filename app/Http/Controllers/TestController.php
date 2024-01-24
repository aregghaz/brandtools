<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSX;

class TestController extends Controller
{
    public function index(Request $request)
    {
        /* open this for local file testing purposes only*/


        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . '/public/uploads/1.xlsx');
        /// $fp = fopen( 'file.csv', 'w');
        ///  $vendorId = $request->user()->vendor_id;
        // $csv_data = file_get_contents(base_path() . '/public/uploads/1.xlsx');

        // $path = $request->file('file');
        // $csv_data = file_get_contents($path);
        /// $data = \Excel::load($path)->get();
        //  $rows = str_getcsv($csv_data, "\n");

//        $result = array();
//        foreach ($xlsx as $k => $row) {
//            if ($k > 0) {
//
//                $result[$k - 1] = str_getcsv($xlsx[$k], ',');
//            }
//        }

        foreach ($xlsx->rows() as $index => $data) {
            // $data = explode(",", $data[0]);

            if ($index !== 0) {
                $category_id = 0;
                $parent_id = 1;
                $name = 2;
                $image = 6;
                $description = 9;
                $meta_title = 10;
                $meta_desc = 11;
                $meta_key = 12;
                $status = 15;;

                $categoryData = Category::create([
                    "title" => $data[$name],
                    'parent_id' => $data[$parent_id],
                    'category_id' => $data[$category_id],
                    'description' => $data[$description],
                    'meta_title' => $data[$meta_title],
                    'meta_desc' => $data[$meta_desc],
                    'meta_key' => $data[$meta_key],
                    'status' => $data[$status] ? 1 : 0,
                    'image' => $data[$image],
                ]);
            }
        }
        $categoryData = Category::all();
        foreach ($categoryData as $data) {
            if ($data->parent_id) {
                $item = Category::where('category_id', $data->parent_id)->limit(1)->get();
                // dd($item);
                $data->parent_id = $item[0]->id;
                $data->save();
            }

//                dd($data);
        }
        return true;
    }

    public function product(Request $request)
    {
        /* open this for local file testing purposes only*/

        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . '/public/uploads/product1.xlsx');
        foreach ($xlsx->rows() as $index => $data) {
            if ($index !== 0) {
                $product_id = 0;
                $name = 1;
                $categoryIds = 2;
                $sku =3;
                $quantity =10;
                $brand= 12;// searck
                $image= 13;
                $price= 15;
                $status= 26;
                $description= 28;
                $meta_title= 29;
                $meta_desc = 30;
                $meta_key = 31;
///dd();

//                $brandData = Brand::where('title', $data[$brand])->first();
//                $brandType = 0;
//                if (isset($brandData)) {
//                    $brandType = $brandData->id;
//                } else {
//                    $dataCreate = Brand::create([
//                        'title' => $data[$brand],
//                        'slug' => $data[$brand],
//                    ]);
//                    $brandType = $dataCreate->id;
//                }
//
//                $product = Product::create([
//                    "name" => $data[$name],
//                    "description" => $data[$description],
//                    "price" => $data[$price],
//                    "brand_id" => $brandType,
//                    "condition_id" => 0,
//                    'product_id' => $data[$product_id],
//                    'sku' => $data[$sku],
//                    'quantity' => $data[$quantity],
//                    'status' => $data[$status] ? 1 : 0,
//                    'image' => $data[$image],
//                    'meta_title' => $data[$meta_title],
//                    'meta_desc' => $data[$meta_desc],
//                    'meta_key' => $data[$meta_key],
//                ]);
                $explodeData = explode(',',$data[$categoryIds]);
              Category::whereIn('category_id',$explodeData)->pluck('id');
            }
        }
        return true;
    }

}
