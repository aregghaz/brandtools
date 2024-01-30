<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryFilterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, "index"]);
// routes/web.php

Route::resource('categories', CategoryController::class);
Route::resource('attributes', AttributeController::class);
////Route::resource('products', ProductController::class);
Route::resource('attribute_values', AttributeValueController::class);
//Route::resource('cart', CartController::class);

Route::get('categories/{category}/filter', [CategoryFilterController::class, 'filter'])->name('categories.filter');
