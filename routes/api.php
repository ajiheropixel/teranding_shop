<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Jalur yang bisa diakses publik (Tanpa Login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Jalur yang harus Login dulu
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/{id}/role', [AuthController::class, 'updateRole']);

    // Nanti di sini kita tambah jalur khusus Admin untuk ganti role
});
