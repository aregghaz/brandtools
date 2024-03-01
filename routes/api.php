<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TegController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/singleProduct/{id}', [HomeController::class, 'singleProduct']);
Route::post('/productsByTeg/{limit}', [HomeController::class, 'getByTeg']);
Route::get('/top-products/{limit}', [\App\Http\Controllers\home\ProductController::class, 'getTopProducts']);
Route::get('/search/{limit}', [\App\Http\Controllers\home\ProductController::class, 'searchProducts']);

Route::get('/category', [HomeController::class, 'category']);
Route::get('/top-category/{limit}', [HomeController::class, 'topCategory']);
Route::get('/category/{id}', [HomeController::class, 'singleCategory']);
Route::get('/singleCat/{id}/{limit}', [HomeController::class, 'singleCat']);

Route::get('/products-by-catId/{id}/{limit}', [HomeController::class, 'productsCategory']);
Route::get('/products-by-brand-id/{id}/{limit}', [HomeController::class, 'brandProducts']);
Route::get('/getTags', [HomeController::class, 'getTags']);

Route::get('/get-brands/{limit}', [HomeController::class, 'getBrand']);
Route::get('/get-single-brands/{id}', [HomeController::class, 'getSingleBrand']);


Route::get('cart-update/{productId}/{qty}', [CartController::class, 'update'])->name('update');
Route::get('delete-cart/{productId}', [CartController::class, 'delete']);
Route::get('get-banners', [HomeController::class, 'getBanners']);

Route::get('get-videos/{limit}', [HomeController::class, 'getVideos']);
Route::get('get-single-videos/{id}', [HomeController::class, 'getSingleVideos']);


Route::get('get-news/{limit}', [HomeController::class, 'getNews']);
Route::get('get-single-news/{id}', [HomeController::class, 'getSingleNews']);
Route::get('getSliders', [HomeController::class, 'getSliders']);


Route::get('/categoryTree', [CategoryController::class, 'categoryTree']);




Route::get('/test', [\App\Http\Controllers\TestController::class, 'index']);
Route::get('/test1/{file}', [\App\Http\Controllers\TestController::class, 'product']);
Route::get('/test2', [\App\Http\Controllers\TestController::class, 'attributes']);
Route::get('/test3/{file}', [\App\Http\Controllers\TestController::class, 'prAttr']);
Route::get('/test4', [\App\Http\Controllers\TestController::class, 'users']);
Route::get('/removeOldImage/{qty}', [\App\Http\Controllers\TestController::class, 'removeOldImage']);
Route::get('add-cart/{productId}/{qty}', [CartController::class, 'index'])->name('add-cart');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
//    Route::group([
//        'namespace' => 'Auth',
//        'prefix' => 'password',
//    ], function () {
//        Route::post('create', 'PasswordResetController@create');
//        Route::get('find/{token}', 'PasswordResetController@find');
//        Route::post('reset', 'PasswordResetController@reset');
//    });

    Route::group([
        'middleware' => 'auth:api'
    ], function () {

        Route::post('/create-order', [OrderController::class, 'createOrder']);
        Route::get('add-cart/{productId}/{qty}', [CartController::class, 'index'])->name('add-cart');
        Route::get('get-cart', [CartController::class, 'getCart'])->name('getCart');
        Route::get('user', [AuthController::class, 'user']);
    });
});
Route::group([
    'middleware' => 'auth:api'
], function () {
//        Route::post('editData', 'UserController@editdata');
//        Route::get('logout', 'AuthController@logout');
    Route::post('/upload-images', [ProductController::class, 'upload']);
    Route::get('/delete-image/{id}', [ProductController::class, 'deleteImage']);
    Route::get('/get-images/{id}', [ProductController::class, 'getImages']);
    Route::post('/products/groupDelete', [ProductController::class,'groupDelete']);
    Route::post('/categories/groupDelete', [CategoryController::class,'groupDelete']);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('users', UserController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('news', NewsController::class);
    Route::resource('video', VideoController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('tags', TegController::class);
//        Route::get('user_orders', 'AuthController@userOrders');
});
