<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index']);

Route::get('/home', [MovieController::class, 'index'])->name('home');

// Static Pages
Route::get('/privacy', fn() => view('pages.privacy'))->name('privacy');
Route::get('/terms', fn() => view('pages.terms'))->name('terms');
Route::get('/movies', [MovieController::class, 'all'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show')->middleware('age.check');


Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/logout', function (Request $request) {
    return app(\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class)->destroy($request);
})->name('logout')->middleware(['auth', 'logoutDevice']);



// Watchlist & Watch History Routes (authenticated users)
Route::middleware('auth')->group(function () {





    // Reviews
    Route::post('/movies/{movie}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/helpful', [\App\Http\Controllers\ReviewController::class, 'helpful'])->name('reviews.helpful');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/security', [\App\Http\Controllers\SettingsController::class, 'security'])->name('settings.security');
    Route::put('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/stats', [\App\Http\Controllers\SettingsController::class, 'stats'])->name('settings.stats');

    // Reviews Story
    Route::get('/reviews-history', [\App\Http\Controllers\ReviewController::class, 'history'])->name('reviews.history.index');



    // Recommendation Debug
    Route::get('/recommendation-debug', [MovieController::class, 'debugRecommendations'])->name('movies.debug');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies', AdminMovieController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});