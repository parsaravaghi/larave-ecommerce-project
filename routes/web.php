<?php

use App\Http\Controllers\Api\{
    AuthController ,
    CategoryController ,
    ProductCotroller ,
};

use App\Http\Controllers\Api\Admin\{
    AdminCategoryController ,
    AdminProductCotroller
};

use Illuminate\Support\Facades\Route;


Route::prefix('/auth')->group(function(){
    Route::post("/register" , [AuthController::class , "register"]);
    Route::post("/login" , [AuthController::class , "login"]);
});

Route::prefix('/product')->group(function(){
    Route::get('/{id}' , [ProductCotroller::class , "show"]);
    Route::get('/' , [ProductCotroller::class , "search"]);
});

Route::prefix("/category")->group(function(){
    Route::get('/{id}' , [CategoryController::class , "show"]);
    Route::get('/' , [CategoryController::class , "search"]);
    Route::get('/parent/{id}' , [CategoryController::class , "showParentIDs"]);
});

Route::prefix('/admin')->group(function(){
    Route::prefix("/product")->group(function(){
        Route::post("/" , [AdminProductCotroller::class , "store"]);
        Route::put("/{id}" , [AdminProductCotroller::class , "update"]);
        Route::delete("/{id}" , [AdminProductCotroller::class , "delete"]);
    });
    Route::prefix('/category')->group(function() {
        Route::post('/' , [AdminCategoryController::class , "store"]);
        Route::put('/{id}' , [AdminCategoryController::class , "update"]);
        Route::delete('/{id}' , [AdminCategoryController::class , "delete"]);
    });
});