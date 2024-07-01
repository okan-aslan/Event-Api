<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeContoller;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('delete', [AuthController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('venues', VenueController::class)->except(['index', 'show']);

    Route::apiResource('events', EventController::class)->except(['index', 'show']);

    Route::prefix('tickets')->group(function () {
        Route::get('/', [TicketController::class, 'index']);
        Route::post('/', [TicketController::class, 'store']);
        Route::get('/{id}', [TicketController::class, 'show']);
        Route::delete('/{id}', [TicketController::class, 'destroy']);
    });
});

Route::apiResource('venues', VenueController::class)->only(['index', 'show']);

Route::apiResource('events', EventController::class)->only(['index', 'show']);

Route::prefix('ticket-types')->group(function () {
    Route::get('/', [TicketTypeContoller::class, 'index']);
    Route::get('/{id}', [TicketTypeContoller::class, 'show']);
});
