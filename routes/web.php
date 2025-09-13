<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('players/{player}', [PlayerController::class, 'show'])->name('players.show');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
