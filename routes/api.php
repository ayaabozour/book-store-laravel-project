<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PaymentMethodController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('categories', [CategoryController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
    });

    Route::get('books', [BookController::class, 'index']);

    Route::middleware('role:author')->group(function () {
        Route::post('books', [BookController::class, 'store']);

        Route::middleware('book.owner')->group(function () {
            Route::put('books/{book}', [BookController::class, 'update']);
            Route::delete('books/{book}', [BookController::class, 'destroy']);
        });
    });

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('payment-methods', [PaymentMethodController::class, 'index']);

    Route::middleware('role:admin')->group(function () {
        Route::post('payment-methods', [PaymentMethodController::class, 'store']);
        Route::delete('payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy']);
    });

});
