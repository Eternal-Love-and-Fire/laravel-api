<?php

use App\Http\Controllers\V1\PositionController;
use App\Http\Controllers\V1\TokenController;
use App\Http\Controllers\V1\UserController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store'])->middleware(ValidateToken::class);
// Route::post('/users', [UserController::class, 'store']);

Route::get('/positions', PositionController::class);

Route::get('/token', TokenController::class);
