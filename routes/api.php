<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChangeOrderStatus;
use App\Http\Controllers\Api\UserBlockListController;
use App\Http\Controllers\Api\Cart\AddToCartController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\CreateGuestUuid;
use App\Http\Controllers\ImageProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Cart\ChangeCartProductController;
use App\Http\Controllers\Api\Cart\ClearCartController;
use App\Http\Controllers\Api\Cart\ShowCartController;
use App\Http\Controllers\Api\Cart\RemoveProductController;
use App\Http\Controllers\Api\Product\ProductController;


Route::prefix('v1')->middleware('api:sanctum')->group(function(){

});

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

//    Route::group(['prefix' => 'order'],function (){
        Route::apiResource('/orders',OrderController::class)->middleware('auth:sanctum');
        Route::patch('/orders/{order}/status',ChangeOrderStatus::class);
//    });
//    Route::group(['middleware'=>'admin'],function (){
    Route::group(['prefix'=>'products/{product}/images'],function (){
        Route::post('/',[ImageProductController::class,'store']);
        Route::post('{image}/data',[ImageProductController::class,'upload'])->name('images.upload');
    });
        Route::apiResource('/products',ProductController::class);
        Route::apiResource('/categories',CategoryController::class);
//        Route::apiResource('/blocks',UserBlockListController::class);
        Route::group(['prefix'=> 'blocks'],function(){
            Route::get('/',[UserBlockListController::class,'index']);
            Route::put('{user}',[UserBlockListController::class,'banUser']);
            Route::delete('{user}',[UserBlockListController::class,'unbanUser']);
        });

        Route::prefix('images')->group(function(){
            Route::post('/',[UploadImageController::class,'store']);
        });
//        Route::group(['prefix'=> '/files'],function (){
//            Route::group(['prefix'=>'images'],function (){
//                Route::apiResource('',ImagesController::class);
//            });
//        });
//    });

    Route::group(['middleware' =>'api:sanctum'],function (){});


    Route::get('/user', function (Request $request) {
        // dd(request()->user);
        // dd(response());
    });
});
