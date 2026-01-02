<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WatchlistController;
use App\Http\Controllers\TransactionController;
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

// Payment callback (public, rate limited)
Route::post('/payment/callback', [TransactionController::class, 'callback'])
    ->middleware('throttle:payment')
    ->name('payment.callback');

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

    // Profiles (Multiple profiles feature)
    Route::prefix('profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::post('/', [ProfileController::class, 'store']);
        Route::post('/{profile}/switch', [ProfileController::class, 'switch']);
        Route::put('/{profile}', [ProfileController::class, 'update']);
        Route::delete('/{profile}', [ProfileController::class, 'destroy']);
    });

    // Watchlist
    Route::prefix('watchlist')->group(function () {
        Route::get('/', [WatchlistController::class, 'index']);
        Route::post('/', [WatchlistController::class, 'store']);
        Route::delete('/{movieId}', [WatchlistController::class, 'destroy']);
    });

    // Watch progress
    Route::get('/continue-watching', [WatchlistController::class, 'continueWatching']);
    Route::post('/watch-progress', [WatchlistController::class, 'updateProgress']);
});