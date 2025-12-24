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
|
*/

// Payment callback (public)
Route::post('/payment/callback', [TransactionController::class, 'callback'])->name('payment.callback');

// Authentication (public)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Public movie endpoints
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{movie}', [MovieController::class, 'show']);
Route::get('/movies/search', [MovieController::class, 'search']);
Route::get('/categories', [MovieController::class, 'categories']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
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