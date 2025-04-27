<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\EnclosureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes
    Route::middleware(['admin'])->group(function () {
        Route::resource('enclosures', EnclosureController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::get('/animals/archived', [AnimalController::class, 'archived'])->name('animals.archived');
        Route::put('/animals/{animal}/restore', [AnimalController::class, 'restore'])->name('animals.restore');

        Route::resource('animals', AnimalController::class)
            ->only(['show', 'create', 'store', 'edit', 'update', 'destroy']);
    });

    Route::resource('enclosures', EnclosureController::class)->only(['index', 'show']);
    Route::resource('animals', AnimalController::class)->only(['index', 'show']);
});


require __DIR__.'/auth.php';
