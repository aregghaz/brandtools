<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\ProductController;
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

Route::get('/test',[\App\Http\Controllers\TestController::class ,'index']);
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
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
//        Route::post('editData', 'UserController@editdata');
//        Route::get('logout', 'AuthController@logout');
        Route::get('user', [AuthController::class, 'user']);
        Route::resource('products', ProductController::class);
//        Route::get('user_orders', 'AuthController@userOrders');
    });
});
Route::group([
    'middleware' => 'auth:api'
], function () {
//        Route::post('editData', 'UserController@editdata');
//        Route::get('logout', 'AuthController@logout');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('conditions', ConditionController::class);
//        Route::get('user_orders', 'AuthController@userOrders');
});
