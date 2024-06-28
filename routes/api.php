<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('delete', [AuthController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('venues', [VenueController::class, 'index']);
Route::get('venue/{venue}', [VenueController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('venues/create', [VenueController::class, 'store']);
    Route::put('venues/{venue}', [VenueController::class, 'update']);
    Route::delete('venues/{venue}', [VenueController::class, 'destroy']);
});