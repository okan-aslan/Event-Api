<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('delete', [AuthController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::apiResource('venues', VenueController::class)->only(['index', 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('venues', VenueController::class)->except(['index', 'show']);
});

Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class)->except(['index', 'show']);
});
