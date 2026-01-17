<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Jalur yang bisa diakses publik (Tanpa Login)
Route::post('/register', [AuthController::class, 'register']);

// TAMBAHKAN ->name('login') di sini agar error merah di Laravel hilang
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Jalur yang harus Login dulu
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/{id}/role', [AuthController::class, 'updateRole']);
});

// Jalur produk sudah di luar, ini sudah BENAR
Route::get('/products', [ProductController::class, 'index']);
Route::post('/checkout', [App\Http\Controllers\OrderController::class, 'store']);
