<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Mobile app and third-party API endpoints for Codeflix.
| Rate limits:
| - api: 60 requests/minute (general endpoints)
| - auth: 10 requests/minute (login/register)
| - payment: 30 requests/minute (payment callbacks)
|
*/



// Authentication (public, stricter rate limit)
Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Public movie endpoints (rate limited)
Route::middleware('throttle:api')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/search', [MovieController::class, 'search']);
    Route::get('/movies/{movie}', [MovieController::class, 'show']);
    Route::get('/categories', [MovieController::class, 'categories']);
});

// Protected routes (require authentication, rate limited)
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // Auth
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Recommendations
    Route::get('/recommendations', [MovieController::class, 'recommendations']);


});