<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
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
