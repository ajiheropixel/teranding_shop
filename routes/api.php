<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\Product;

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
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
