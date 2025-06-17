<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Todo\ItemController;
use App\Http\Controllers\Api\Todo\ListController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('checklist')->group(function () {
        Route::get('/', [ListController::class, 'index']);
        Route::post('/', [ListController::class, 'store']);
        Route::put('/{id}', [ListController::class, 'update']);
        Route::delete('/{id}', [ListController::class, 'destroy']);

        Route::prefix('/{list_id}/item')->group(function () {
            Route::get('/', [ListController::class, 'show']);
            Route::post('/', [ItemController::class, 'store']);
            Route::get('/{id}', [ItemController::class, 'show']);
            Route::put('/{id}', [ItemController::class, 'update']);
            Route::delete('/{id}', [ItemController::class, 'destroy']);
        });
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
