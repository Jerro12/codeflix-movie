<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\WatchHistoryController;
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
Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');

// Series Routes
Route::get('/series', [\App\Http\Controllers\SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{series:slug}', [\App\Http\Controllers\SeriesController::class, 'show'])->name('series.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/logout', function (Request $request) {
    return app(\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class)->destroy($request);
})->name('logout')->middleware(['auth', 'logoutDevice']);

Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])->name('subscribe.plans');
Route::get('/subscribe/plan/{plan}', [SubscribeController::class, 'checkoutPlan'])->name('subscribe.checkout');
Route::post('/subscribe/checkout', [SubscribeController::class, 'processCheckout'])->name('subscribe.process');
Route::get('/subscribe/success', [SubscribeController::class, 'showSuccess'])->name('subscribe.success');

Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');

// Watchlist & Watch History Routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/my-list', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/{movie}/toggle', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
    Route::get('/watchlist/{movie}/check', [WatchlistController::class, 'check'])->name('watchlist.check');
    Route::post('/watch-progress', [WatchHistoryController::class, 'updateProgress'])->name('watch.progress');
    Route::get('/continue-watching', [WatchHistoryController::class, 'getContinueWatching'])->name('watch.continue');

    // Profiles (Multiple profiles feature)
    Route::get('/profiles', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/create', [\App\Http\Controllers\ProfileController::class, 'create'])->name('profiles.create');
    Route::post('/profiles', [\App\Http\Controllers\ProfileController::class, 'store'])->name('profiles.store');
    Route::post('/profiles/{profile}/switch', [\App\Http\Controllers\ProfileController::class, 'switch'])->name('profiles.switch');
    Route::delete('/profiles/{profile}', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profiles.destroy');

    // Reviews
    Route::post('/movies/{movie}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/helpful', [\App\Http\Controllers\ReviewController::class, 'helpful'])->name('reviews.helpful');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/security', [\App\Http\Controllers\SettingsController::class, 'security'])->name('settings.security');
    Route::put('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/stats', [\App\Http\Controllers\SettingsController::class, 'stats'])->name('settings.stats');

    // Watch History
    Route::get('/history', [WatchHistoryController::class, 'index'])->name('history.index');
    Route::delete('/history/{history}', [WatchHistoryController::class, 'destroy'])->name('history.destroy');

    // Referral
    Route::get('/referral', [\App\Http\Controllers\ReferralController::class, 'index'])->name('referral.index');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies', AdminMovieController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});





Route::get('/test-expired', function () {
    $membership = \App\Models\Membership::find(1);
    event(new \App\Events\MembershipHasExpired($membership));

    return 'Event fired';
})->name('test-expired');