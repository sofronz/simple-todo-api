<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);