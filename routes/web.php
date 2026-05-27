<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::post('/movies/save-or-update', [MovieController::class, 'saveOrUpdate'])
        ->name('movies.saveOrUpdate');

    Route::post('/movies/store-from-api', [MovieController::class, 'storeFromApi'])
        ->name('movies.storeFromApi');

    Route::get('/movies/tmdb/{id}', [MovieController::class, 'showFromApi'])
        ->name('movies.showFromApi');

    Route::patch('/movies/{movie}/favorite', [MovieController::class, 'toggleFavorite'])
        ->name('movies.toggleFavorite');

    Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');

    Route::resource('movies', MovieController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';