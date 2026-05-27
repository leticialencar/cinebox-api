<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $movies = Movie::where('user_id', $userId)
            ->latest()
            ->get();

        $apiKey = config('services.tmdb.key');

        $popularResponse = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ]);

        $popular = $popularResponse->successful()
            ? ($popularResponse->json()['results'] ?? [])
            : [];

        $upcomingResponse = Http::get('https://api.themoviedb.org/3/movie/upcoming', [
            'api_key' => $apiKey,
            'language' => 'pt-BR',
            'region'   => 'BR',
        ]);

        $upcoming = $upcomingResponse->successful()
            ? ($upcomingResponse->json()['results'] ?? [])
            : [];

        $topRatedResponse = Http::get('https://api.themoviedb.org/3/movie/top_rated', [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ]);

        $topRated = $topRatedResponse->successful()
            ? ($topRatedResponse->json()['results'] ?? [])
            : [];

        return view('movies.index', compact('movies', 'popular', 'upcoming', 'topRated'));
    }

    public function storeFromApi(Request $request)
    {
        $data = $request->validate([
            'tmdb_id'      => 'required',
            'title'        => 'required|string|max:255',
            'release_year' => 'nullable|integer',
            'description'  => 'nullable|string',
            'poster'       => 'nullable|string',
            'rating'       => 'nullable|numeric|min:0|max:10'
        ]);

        $userId = Auth::id();

        $exists = Movie::where('user_id', $userId)
            ->where('tmdb_id', $data['tmdb_id'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('movies.index')
                ->with('success', 'Esse filme já está na sua coleção!');
        }

        Movie::create([
            ...$data,
            'user_id' => $userId,
        ]);

        return redirect()
            ->route('movies.index')
            ->with('success', 'Filme adicionado com sucesso!');
    }

    public function showFromApi($id)
    {
        $apiKey = config('services.tmdb.key');

        $movie = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ])->json();

        if (!$movie) {
            abort(404, 'Filme não encontrado');
        }

        $movie['videos'] = Http::get("https://api.themoviedb.org/3/movie/{$id}/videos", [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ])->json('results') ?? [];

        if (empty($movie['videos'])) {
            $movie['videos'] = Http::get("https://api.themoviedb.org/3/movie/{$id}/videos", [
                'api_key' => $apiKey,
                'language' => 'en-US'
            ])->json('results') ?? [];
        }

        $movie['credits'] = Http::get("https://api.themoviedb.org/3/movie/{$id}/credits", [
            'api_key' => $apiKey,
            'language' => 'pt-BR'
        ])->json() ?? ['cast' => [], 'crew' => []];

        $movie['backdrop'] = !empty($movie['backdrop_path'])
            ? "https://image.tmdb.org/t/p/original{$movie['backdrop_path']}"
            : null;

        $movie['poster'] = !empty($movie['poster_path'])
            ? "https://image.tmdb.org/t/p/w500{$movie['poster_path']}"
            : null;

        $movie['rating'] = isset($movie['vote_average'])
            ? number_format($movie['vote_average'], 1)
            : '0.0';

        $movie['release'] = $movie['release_date'] ?? null;

        $movie['director'] = collect($movie['credits']['crew'])
            ->firstWhere('job', 'Director')['name'] ?? '—';

        $movie['writer'] = collect($movie['credits']['crew'])
            ->firstWhere('job', 'Writer')['name']
            ?? collect($movie['credits']['crew'])->firstWhere('job', 'Screenplay')['name']
            ?? '—';

        $movie['studios'] = collect($movie['production_companies'] ?? [])
            ->pluck('name')
            ->take(2)
            ->implode(', ');

        $cast = $movie['credits']['cast'] ?? [];

        $title = $movie['title'] ?? '—';
        $description = $movie['overview'] ?? '';
        $poster = $movie['poster'];
        $backdrop = $movie['backdrop'];
        $rating = $movie['rating'];
        $release = $movie['release'];
        $director = $movie['director'];
        $writer = $movie['writer'];
        $studios = $movie['studios'];
        $videos = collect($movie['videos']);

        $movieTitle = strtolower($movie['title'] ?? '');
        $firstWord = strtolower(explode(' ', trim($movieTitle))[0]);

        $trailer = $videos->first(function ($v) use ($firstWord) {
            $name = strtolower($v['name'] ?? '');
            return $v['type'] === 'Trailer'
                && ($v['official'] ?? false) === true
                && str_contains($name, $firstWord);
        })['key'] ?? null
        ?: ($videos->skip(1)->firstWhere('type', 'Trailer')['key'] ?? null)
        ?: ($videos->firstWhere('type', 'Trailer')['key'] ?? null);

        $runtime = $movie['runtime'] ?? null;
        $hours = $runtime ? floor($runtime / 60) : null;
        $minutes = $runtime ? $runtime % 60 : null;

        $userRating = null;

        $userId = Auth::id();
        $userData = Movie::where('user_id', $userId)
            ->where('tmdb_id', $id)
            ->first();

        return view('movies.show', compact(
            'movie',
            'cast',
            'title',
            'description',
            'poster',
            'backdrop',
            'rating',
            'release',
            'director',
            'writer',
            'studios',
            'trailer',
            'hours',
            'minutes',
            'userRating',
            'id',
            'userData'
        ));
    }

    public function destroy(Movie $movie)
    {
        if ($movie->user_id !== Auth::id()) {
            abort(403);
        }

        $movie->delete();

        return redirect()
            ->route('movies.index')
            ->with('success', 'Filme removido com sucesso!');
    }

    public function edit(Movie $movie)
    {
        if ($movie->user_id !== Auth::id()) {
            abort(403);
        }

        return view('movies.edit', compact('movie'));
    }

    public function saveOrUpdate(Request $request)
    {
        $data = $request->validate([
            'tmdb_id'     => 'required',
            'title'       => 'required|string|max:255',
            'poster'      => 'nullable|string',
            'user_rating' => 'nullable|integer|min:0|max:10',
            'review'      => 'nullable|string|max:2000',
        ]);

        $userId = Auth::id();

        $movie = Movie::where('user_id', $userId)
            ->where('tmdb_id', $data['tmdb_id'])
            ->first();

        if ($movie) {
            $movie->update([
                'user_rating' => $data['user_rating'],
                'review'      => $data['review'],
            ]);
        } else {
            Movie::create([
                'user_id'     => $userId,
                'tmdb_id'     => $data['tmdb_id'],
                'title'       => $data['title'],
                'poster'      => $data['poster'],
                'user_rating' => $data['user_rating'],
                'review'      => $data['review'],
            ]);
        }

        return back()->with('success', 'Avaliação salva com sucesso!');
    }
    
    public function toggleFavorite(Movie $movie)
    {
        if ($movie->user_id !== Auth::id()) {
            abort(403);
        }

        $movie->is_favorite = !$movie->is_favorite;
        $movie->save();

        return back();
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Http::get('https://api.themoviedb.org/3/search/movie', [
            'api_key'  => config('services.tmdb.key'),
            'language' => 'pt-BR',
            'query'    => $query,
        ])->json()['results'] ?? [];

        return response()->json(
            collect($results)->take(6)->map(fn($m) => [
                'id'          => $m['id'],
                'title'       => $m['title'],
                'year'        => substr($m['release_date'] ?? '', 0, 4),
                'poster'      => $m['poster_path']
                    ? 'https://image.tmdb.org/t/p/w92' . $m['poster_path']
                    : null,
            ])
        );
    }

}