<?php

use App\Http\Controllers\ActiveDraftController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('players/{player}', [PlayerController::class, 'show'])->name('players.show');

    Route::post('drafts', [DraftController::class, 'store'])->name('drafts.store');
    Route::get('drafts/{draft}', [DraftController::class, 'show'])->name('drafts.show');

    Route::post('active-drafts', [ActiveDraftController::class, 'store'])->name('active-drafts.store');
    Route::delete('active-drafts/{id}', [ActiveDraftController::class, 'destroy'])->name('active-drafts.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
