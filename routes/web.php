<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [UserController::class,'login']);
Route::get('/',[ProductController::class,'index']);
Route::get('/detail/{id}', [ProductController::class,'detail']);
Route::get('/cartlist', [ProductController::class,'CartList']);
Route::post('/add_to_cart', [ProductController::class,'addToCart']);

Route::get('/logout', function (){
    Session::forget('user');
    return redirect('login');
});
Route::get('removecart/{id}', [ProductController::class,'removeCart']);
Route::get('ordernow', [ProductController::class,'orderNow']);