<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;

Route::post("/login",[AuthController::class,'login']);

Route::middleware('auth:api')->group(function (){
    Route::post("/logout",[AuthController::class,'logout']);
    Route::post("/refresh",[AuthController::class,'refresh']);
    Route::get("/me",[AuthController::class,'me']);

    Route::prefix('admin')->group(function (){
        Route::get('blogs',[AdminController::class,'adminBlogs']);
        Route::post('blog/add',[AdminController::class,'adminBlogAdd']);
        Route::get('blog/update/{blog_id}',[AdminController::class,'adminBlogtoUpdate']);
        Route::post('blog/update/{blog_id}',[AdminController::class,'adminBlogUpdate']);
        Route::post('blog/delete',[AdminController::class,'adminBlogDelete']);
    });
});

Route::prefix('yrw')->group(function (){
    Route::get('/blogs',[FrontController::class,'allBlogs']);
});
