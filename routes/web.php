<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Game\TruthOrLieController;
use App\Http\Controllers\Game\WouldYouRatherController;
use App\Http\Controllers\Game\TwoTruthsOneLieController;
use App\Http\Controllers\Game\FakeNewsController;
use Illuminate\Http\Request;

// Public routes
Route::get('/', function () {
    return Inertia::render ('Home');
});
Route::get('/about', function () {
    return Inertia::render ('About');
});
Route::get('/privacy', function () {
    return Inertia::render ('Privacy');
});
Route::get('/truth-or-lie', [TruthOrLieController::class, 'show'])->name('truth-or-lie.play');
Route::post('/truth-or-lie/check', [TruthOrLieController::class, 'check'])->name('truth-or-lie.check');
Route::get('/would-you-rather', [WouldYouRatherController::class, 'show'])->name('would-you-rather.play');
Route::get('/two-truths-one-lie', [TwoTruthsOneLieController::class, 'show'])->name('two-truths-one-lie.play');
Route::get('/fake-news', [FakeNewsController::class, 'show'])->name('fake-news.play');

// API routes (should not be indexed or visible to public, add middleware)
Route::middleware(['web', 'throttle:60,1'])->prefix('api')->group(function () {
    Route::get('/truth-or-lie/random', [TruthOrLieController::class, 'apiRandom']);
    Route::post('/truth-or-lie/check', [TruthOrLieController::class, 'apiCheck']);

    Route::get('/would-you-rather/random', [WouldYouRatherController::class, 'apiRandom']);
    Route::post('/would-you-rather/answer', [WouldYouRatherController::class, 'apiAnswer']);

    Route::get('/two-truths-one-lie/random', [TwoTruthsOneLieController::class, 'apiRandom']);
    Route::post('/two-truths-one-lie/answer', [TwoTruthsOneLieController::class, 'apiAnswer']);

    Route::get('/fake-news/random', [FakeNewsController::class, 'apiRandom']);
    Route::post('/fake-news/answer', [FakeNewsController::class, 'apiAnswer']);
});