<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// publicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/media/popular', [MovieController::class, 'popular']);

// autenticadas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user/avatar', [ProfileController::class, 'updateAvatar']);

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