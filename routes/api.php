<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::put('/user/update/{id}', [UserController::class, 'update']);
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);

    // Order routes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/order/store', [OrderController::class, 'store']);
    Route::put('/order/update/{id}', [OrderController::class, 'update']);
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroy']);
    Route::get('/user/{id}/orders', [OrderController::class, 'userOrders']);
});
