<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CallBackController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FiltrationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TegController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WishListController;
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

Route::get('/subscription/{email}', [\App\Http\Controllers\SubscriptionController::class, 'create']);
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
Route::get('/get-single-brands-name', [HomeController::class, 'getSingleBrandByName']);

Route::get('get-banners', [HomeController::class, 'getBanners']);


Route::get('contacts-us', [\App\Http\Controllers\ContactController::class, 'index']);
Route::post('request-price', [\App\Http\Controllers\ContactController::class, 'requestPrice']);
Route::post('call-back/add', [CallBackController::class, 'store']);
Route::post('questions', [QuestionController::class, 'store']);


Route::get('get-videos/{limit}', [HomeController::class, 'getVideos']);
Route::get('get-single-videos/{id}', [HomeController::class, 'getSingleVideos']);


Route::get('get-news/{limit}', [HomeController::class, 'getNews']);
Route::get('get-single-news/{id}', [HomeController::class, 'getSingleNews']);
Route::get('getSliders', [HomeController::class, 'getSliders']);

Route::get('/categoryTree', [CategoryController::class, 'categoryTree']);
Route::post('/filtration/{id}/{limit}', [FiltrationController::class, 'index']);
Route::group(['prefix' => 'wishlist'], function () {
    Route::get('add-wishlist/{productId}/{qty}', [WishListController::class, 'index'])->name('add-cart');
    Route::get('get-wishlist/{limit}', [WishListController::class, 'getCart'])->name('getCart');
    Route::get('wishlist-update/{productId}/{qty}', [WishListController::class, 'update'])->name('update');
    Route::get('delete-wishlist/{productId}', [WishListController::class, 'delete']);

});


//
//Route::get('/test', [\App\Http\Controllers\TestController::class, 'index']);
//Route::get('/test1/{file}', [\App\Http\Controllers\TestController::class, 'product']);
//Route::get('/test2', [\App\Http\Controllers\TestController::class, 'attributes']);
//;
//Route::get('/test4', [\App\Http\Controllers\TestController::class, 'users']);
//Route::get('/removeOldImage/{qty}', [\App\Http\Controllers\TestController::class, 'removeOldImage']);

Route::get('add-cart/{productId}/{qty}', [NoAuthController::class, 'index'])->name('add-cart');
Route::get('get-cart', [NoAuthController::class, 'getCart'])->name('getCart');
Route::get('cart-update/{productId}/{qty}', [NoAuthController::class, 'update'])->name('update');
Route::get('delete-cart/{productId}', [NoAuthController::class, 'delete']);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/create-order', [OrderController::class, 'createOrder']);
        Route::get('add-cart/{productId}/{qty}', [CartController::class, 'index'])->name('add-cart');
        Route::get('get-cart', [CartController::class, 'getCart'])->name('getCart');
        Route::get('cart-update/{productId}/{qty}', [CartController::class, 'update'])->name('update');
        Route::get('delete-cart/{productId}', [CartController::class, 'delete']);
        Route::get('user', [AuthController::class, 'user']);
        Route::get('reset', [AuthController::class, 'resetPassword']);
        Route::post('/update/{id}', [AuthController::class, 'update']);
        Route::get('/get-orders/{limit}', [\App\Http\Controllers\home\OrderController::class, 'getOrders']);
        Route::get('/single-orders/{id}', [\App\Http\Controllers\home\OrderController::class, 'getSingleOrder']);

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
    Route::post('/products/groupAddTeg', [ProductController::class, 'groupAddTag']);
    Route::post('/products/groupDelete', [ProductController::class, 'groupDelete']);
    Route::post('/categories/groupDelete', [CategoryController::class, 'groupDelete']);
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
    Route::get('call-back', [CallBackController::class, 'index']);
    Route::get('contacts', [\App\Http\Controllers\ContactController::class, 'index']);
    Route::get('/request-price/{id}', [\App\Http\Controllers\ContactController::class, 'getSingleRequestPrice']);
    Route::put('contacts/{id}', [\App\Http\Controllers\ContactController::class, 'update']);
    Route::delete('call-back/{id}', [CallBackController::class, 'destroy']);
    Route::get('request-price', [\App\Http\Controllers\ContactController::class, 'getAllRequest']);

    Route::get('questions', [QuestionController::class, 'index']);
    Route::post('/questions/groupDelete', [QuestionController::class, 'groupDelete']);

    Route::delete('request-price/{id}', [\App\Http\Controllers\ContactController::class, 'deleteRequestPrice']);
    Route::post('/request-price/groupDelete', [\App\Http\Controllers\ContactController::class, 'priceGroupDelete']);


//        Route::get('user_orders', 'AuthController@userOrders');
});
