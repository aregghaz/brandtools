<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function product(Request $request, $file)
    {
        /* open this for local file testing purposes only*/
        ///Product::truncate();
        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . "/public/uploads/product$file.xlsx");
        /// $xlsx = SimpleXLSX::parse(base_path() . "/public/uploads/pr1.xlsx");
        foreach ($xlsx->rows(0) as $index => $data) {
            $status = 26;
            if ($index !== 0 and $data[$status] === 'true') {
                $product_id = 0;
                $name = 1;
                $categoryIds = 2;
                $sku = 3;
                $stock = 9;
                $quantity = 10;
                $brand = 12;// searck
                $image = 13;
                $price = 15;
                $description = 28;
                $meta_title = 29;
                $meta_desc = 30;
                $meta_key = 31;
                ///// $brandData = Brand::where('title', $data[$brand])->first();
                $brandType = 0;

                $product = Product::where('product_id', $data[$product_id])->update([
                    'stock' => $data[$stock] ?? null
                ]);


                /////Brend insert
                ///
                ///
                ///
//                if (isset($brandData)) {
//                    $brandType = $brandData->id;
//                } else {
//                    $dataCreate = Brand::create([
//                        'title' => $data[$brand],
//                        'slug' => $data[$brand],
//                    ]);
//                    $brandType = $dataCreate->id;
//                }
//                $images = explode('.JPG', $data[$image]);
//                $imageUrl = 'https://brendinstrument.ru/image/cache/' . $images[0] . '-351x265.JPG';
//

//                $uniqid = Str::random(9);
//                $images = explode('.JPG', $data[$image]);
//                $imageUrl = 'https://brendinstrument.ru/image/cache/' . $images[0] .'-351x265.JPG';
//                //$imageUrl = 'https://brendinstrument.ru/image/' . $data[$image];
//
//                @$rawImage = file_get_contents($imageUrl);
//
//                if ($rawImage) {
//                    $storageName = "/storage/images/products/" .$uniqid.'.jpg';
//                    if (!Storage::exists($storageName)) {
//                        Storage::put("public/images/products/" .$uniqid.'.jpg', $rawImage);
//                    }
//                    $product = Product::create([
//                        "name" => $data[$name],
//                        "description" => $data[$description],
//                        "price" => $data[$price],
//                        "brand_id" => $brandType,
//                        'product_id' => $data[$product_id],
//                        'sku' => $data[$sku],
//                        'quantity' => $data[$quantity],
//                        'status' => 1,
//                        'image' => $storageName,
//                        'meta_title' => $data[$meta_title],
//                        'meta_desc' => $data[$meta_desc],
//                        'meta_key' => $data[$meta_key],
//                    ]);
//                }
//                else {
//                    $product = Product::create([
//                        "name" => $data[$name],
//                        "description" => $data[$description],
//                        "price" => $data[$price],
//                        "brand_id" => $brandType,
//                        'product_id' => $data[$product_id],
//                        'sku' => $data[$sku],
//                        'quantity' => $data[$quantity],
//                        'status' => 0,
//                        'image' => null,
//                        'meta_title' => $data[$meta_title],
//                        'meta_desc' => $data[$meta_desc],
//                        'meta_key' => $data[$meta_key],
//                    ]);
//                }
//                $explodeData = explode(',', $data[$categoryIds]);
//                $categ = Category::whereIn('category_id', $explodeData)->pluck('id');
//                $product->categories()->sync($categ);
//            }
//        }
//        foreach ($xlsx->rows(7) as $index => $data) {
//            if ($index !== 0) {
//                $product_id = 0;
//                $attribute_id = 2;
//                $value = 3;
//                $product = Product::where('product_id', $data[$product_id])->first();
//                $attr = Attribute::where('attribute_id', $data[$attribute_id])->first();
//                if (isset($product) and isset($attr)) {
//                    $product->attributes()->attach($attr->id, ['value' => trim(preg_replace('/\s\s+/', '', $data[$value]))]);
//                }
//            }
//        }
//        foreach ($xlsx->rows(1) as $index => $data) {
//            if ($index !== 0) {
//                $product_id = 0;
//                $attribute_id = 1;
//                $value = 3;
//                $product = Product::where('product_id', $data[$product_id])->first();
//                var_dump(isset($product) );
//
//                if (isset($product)) {
//                    $uniqid = Str::random(9);
//                    $images = explode('.JPG', $data[$attribute_id]);
//                    $imageUrl = 'https://brendinstrument.ru/image/cache/' . $images[0] . '-640x480.JPG';
//                    $storageName = "/storage/images/products/" .$uniqid.'.jpg';
//                   // if (!Storage::exists($storageName)) {
//                        @$rawImage = file_get_contents($imageUrl);
//                        if ($rawImage) {
//                            Storage::put("public/images/products/" . $uniqid.'.jpg', $rawImage);
//                            ProductImage::create([
//                                "path" => $storageName,
//                                "product_id" => $product->id,
//                                "sort" => 1,
//                            ]);
//                        }
//                  //  }
//
//
//                }
            }
        }
        return true;
    }

    public function attributes(Request $request)
    {
        /* open this for local file testing purposes only*/

        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . '/public/uploads/attributes.xlsx');
        foreach ($xlsx->rows() as $index => $data) {
            if ($index !== 0) {
                $attribute_id = 0;
                $type = 1;
                $name = 2;
                Attribute::create([
                    "title" => $data[$name],
                    "attribute_id" => $data[$attribute_id],
                    "type" => $data[$type] === 0 ? 1 : 2,

                ]);

            }
        }
        return true;
    }

    public function prAttr(Request $request)
    {
        /* open this for local file testing purposes only*/

        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . '/public/uploads/prattr1.xlsx');
        foreach ($xlsx->rows() as $index => $data) {
            if ($index !== 0) {
                $product_id = 0;
                $attribute_id = 2;
                $value = 3;

                $product = Product::where('product_id', $data[$product_id])->first();
                $attr = Attribute::where('attribute_id', $data[$attribute_id])->first();
                if (isset($product)) {
                    $product->attributes()->attach($attr, ['value' => trim(preg_replace('/\s\s+/', '', $data[$value]))]);

                }

            }
        }
        return true;
    }

    public function users(Request $request)
    {
        /* open this for local file testing purposes only*/
        set_time_limit(0);
        /// DB::beginTransaction();
        $xlsx = SimpleXLSX::parse(base_path() . '/public/uploads/users.xlsx');
        foreach ($xlsx->rows() as $index => $data) {

            if ($index !== 0) {
                $name = 3;
                $lastName = 4;
                $email = 5;
                $phone = 6;
                $password = 8;
                $subscribed = 12;
                $status = 15;

                User::create([
                    'name' => $data[$name],
                    'lastName' => $data[$lastName],
                    'email' => $data[$email],
                    'phone' => $data[$phone],
                    'password' => $data[$password],
                    'subscribed' => $data[$subscribed] === 'yes' ? 1 : 0,
                    'status' => $data[$status] === 'true' ? 1 : 0
                ]);

            }
        }
        return true;
    }

    public function removeOldImage($qty)
    {
        $image = Product::limit(1000 * $qty)->orderBy('id', 'DESC')->get();
        foreach ($image as $item) {
            $images = explode('.JPG', $item->image);
            $imageUrl = 'https://brendinstrument.ru/image/cache/' . $images[0] . '-351x265.JPG';
            @$rawImage = file_get_contents($imageUrl);
            if ($rawImage) {
                Storage::put("public/images/products/" . basename($imageUrl), $rawImage);
                $storageName = "/storage/images/products/" . basename($imageUrl);
                $item->update([
                    'image' => $storageName,
                ]);
                echo 'Image Saved';
            } else {
                $item->update([
                    'status' => 0,
                ]);
                echo 'Error Occured';
            }
        }
        return true;
    }

    public function image()
    {
        $product = Product::find(123);
        // Create image instances
        $dest = imagecreatefromgif(
            'https://media.geeksforgeeks.org/wp-content/uploads/animateImages.gif');
        $src = imagecreatefromgif(
            'https://media.geeksforgeeks.org/wp-content/uploads/slider.gif');

// Copy and merge
        $img = imagecopymerge($dest, $src, 10, 10, 0, 0, 500, 200, 75);
        ///return json()->response($img);
        ///
        header('Content-Type: image/gif');
        imagegif($dest);

        imagedestroy($dest);
        imagedestroy($src);


    }
}
