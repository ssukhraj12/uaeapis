<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\RblogController;

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
        Route::get('/gallery',[AdminController::class,'adminGalleryList']);
        Route::post('/gallery/add',[AdminController::class,'adminGalleryAdd']);
        Route::post('/gallery/update/{gallery_id}',[AdminController::class,'adminGalleryUpdate']);
        Route::post('/gallery/delete/{gallery_id}',[AdminController::class,'adminGalleryDelete']);
        Route::get('rblogs',[RblogController::class,'adminrBlogs']);
        Route::post('rblog/add',[RblogController::class,'adminrBlogAdd']);
        Route::get('rblog/update/{rblog_id}',[RblogController::class,'adminrBlogtoUpdate']);
        Route::post('rblog/update/{rblog_id}',[RblogController::class,'adminrBlogUpdate']);
        Route::post('rblog/delete',[RblogController::class,'adminrBlogDelete']);
    });
});

Route::prefix('yrw')->group(function (){
    Route::get('/blogs',[FrontController::class,'allBlogs']);
    Route::get('/galleries',[FrontController::class,'allGallery']);
});

Route::prefix('rakhee')->group(function (){
    Route::get('/rblogs',[FrontController::class,'allrBlogs']);
});
