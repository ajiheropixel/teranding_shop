<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Models\Order;

// Route Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', function (Illuminate\Http\Request $request) {
    $query = $request->search;
    return \App\Models\Product::where('name', 'like', "%$query%")->get();
});

Route::post('/checkout', [OrderController::class, 'store']);
Route::post('/user/update', [UserController::class, 'update']);

// Route Protected (Opsional)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/orders', function () {
    return response()->json(Order::all());
});
