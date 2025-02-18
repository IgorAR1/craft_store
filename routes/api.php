<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Cart\AddToCartController;
use App\Http\Controllers\Api\Cart\ChangeCartProductController;
use App\Http\Controllers\Api\Cart\ClearCartController;
use App\Http\Controllers\Api\Cart\RemoveProductController;
use App\Http\Controllers\Api\Cart\ShowCartController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\UserBlockListController;
use App\Http\Controllers\CreateGuestUuid;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ImageProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::prefix('/auth')->group(function(){
        Route::post('/register',[AuthController::class,'register']);
        Route::post('/login',[AuthController::class,'login'])->name('auth.login');
        Route::get('/guest/auth',CreateGuestUuid::class);
    });
    Route::prefix('/cart')->group(function(){
        Route::get('/',ShowCartController::class);
        Route::post('/',AddToCartController::class);
        Route::delete('/',ClearCartController::class);
        Route::prefix('/{product}')->group(function(){
            Route::put('/',ChangeCartProductController::class);
            Route::delete('/',RemoveProductController::class);
        });
    });
    Route::apiResource('/orders',OrderController::class)->middleware('auth:sanctum');
    Route::group(['prefix'=>'products/{product}/images'],function (){
        Route::post('/',[ImageProductController::class,'store']);
        Route::post('{image}/data',[ImageProductController::class,'upload'])->name('images.upload');
    });
    Route::apiResource('/products',ProductController::class);
    Route::apiResource('/categories',CategoryController::class);
    Route::apiResource('/discounts',DiscountController::class);
    Route::group(['prefix'=> 'blocks'],function(){
        Route::get('/',[UserBlockListController::class,'index']);
        Route::put('{user}',[UserBlockListController::class,'banUser']);
        Route::delete('{user}',[UserBlockListController::class,'unbanUser']);
    });
    Route::prefix('images')->group(function(){
        Route::post('/',[UploadImageController::class,'store']);
    });

    Route::group(['middleware' =>'api:sanctum'],function (){});

    Route::get('/user', function (Request $request) {
        // dd(request()->user);
        // dd(response());
    });
});
