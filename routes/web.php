<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*')->name('homepage');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
