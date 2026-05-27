<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $apiKey = config('services.tmdb.key');

        $movies = Movie::where('user_id', Auth::id())->latest()->get();

        $popular = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key'  => $apiKey,
            'language' => 'pt-BR'
        ])->json()['results'] ?? [];

        $upcoming = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
            'api_key'  => $apiKey,
            'language' => 'pt-BR',
            'region'   => 'BR',
        ])->json()['results'] ?? [];

        $topRated = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
            'api_key'  => $apiKey,
            'language' => 'pt-BR',
        ])->json()['results'] ?? [];

        return view('dashboard', compact('movies', 'popular', 'upcoming', 'topRated'));
    }

    public function welcome()
    {
        $popular = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key'  => config('services.tmdb.key'),
            'language' => 'pt-BR'
        ])->json()['results'] ?? [];

        return view('welcome', compact('popular'));
    }
}