<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnclosureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('enclosures', EnclosureController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('animals', AnimalController::class)->only(['index', 'show']);

    // Admin-only routes
    Route::middleware(['admin'])->group(function () {
        Route::resource('enclosures', EnclosureController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('animals', AnimalController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('/archived-animals', [AnimalController::class, 'archived'])->name('animals.archived');
        Route::post('/animals/{animal}/restore', [AnimalController::class, 'restore'])->name('animals.restore');
    });
});

require __DIR__.'/auth.php';
