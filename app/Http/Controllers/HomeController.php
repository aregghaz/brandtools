<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index () {
       $product = Product::get();
       return view('welcome', [
           "products" => $product
       ]);
   }
}
