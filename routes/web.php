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