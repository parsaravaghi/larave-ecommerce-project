<?php

use App\Http\Controllers\Api\Admin\AdminProductCotroller;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCotroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/auth')->group(function(){
    Route::post("/register" , [AuthController::class , "register"]);
    Route::post("/login" , [AuthController::class , "login"]);
});

Route::prefix('/product')->group(function(){
    Route::get('/{id}' , [ProductCotroller::class , "show"]);
    Route::get('/' , [ProductCotroller::class , "search"]);
});

Route::prefix("/admin")->group(function(){
    Route::prefix("product")->group(function(){
        Route::post("/" , [AdminProductCotroller::class , "store"]);
        Route::put("/{id}" , [AdminProductCotroller::class , "edit"]);
        Route::delete("/{id}" , [AdminProductCotroller::class , "remove"]);
    });
});