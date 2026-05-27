<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']);
    Route::post('/movies/store-from-api', [MovieController::class, 'storeFromApi']);
    Route::post('/movies/save-or-update', [MovieController::class, 'saveOrUpdate']);
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy']);
    Route::patch('/movies/{movie}/favorite', [MovieController::class, 'toggleFavorite']);

    Route::get('/media/search', [MovieController::class, 'search']);
    Route::get('/media/{type}/{id}', [MovieController::class, 'showFromApi'])
                ->where('type', 'movie|tv')
                ->name('movies.showFromApi'); 
});