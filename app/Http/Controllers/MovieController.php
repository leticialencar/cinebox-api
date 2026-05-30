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

        return response()->json([
            'collection' => $movies,
        ]);
    }

    public function storeFromApi(Request $request)
    {
        $data = $request->validate([
            'tmdb_id'      => 'required',
            'title'        => 'required|string|max:255',
            'release_year' => 'nullable|integer',
            'description'  => 'nullable|string',
            'poster'       => 'nullable|string',
            'rating'       => 'nullable|numeric|min:0|max:10',
            'media_type'   => 'nullable|in:movie,tv',
        ]);

        $userId = Auth::id();

        $exists = Movie::where('user_id', $userId)
            ->where('tmdb_id', $data['tmdb_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Esse título já está na sua coleção.',
            ], 409);
        }

        $movie = Movie::create([
            ...$data,
            'user_id' => $userId,
        ]);

        return response()->json([
            'message' => 'Título adicionado com sucesso.',
            'movie'   => $movie,
        ], 201);
    }

    public function showFromApi(string $type, int $id)
    {
        abort_unless(in_array($type, ['movie', 'tv']), 404);

        $apiKey = config('services.tmdb.key');

        $item = Http::get("https://api.themoviedb.org/3/{$type}/{$id}", [
            'api_key' => $apiKey,
            'language' => 'pt-BR',
        ])->json();

        if (!$item) {
            abort(404, 'Título não encontrado');
        }

        $title   = $item['title']        ?? $item['name']           ?? '—';
        $release = $item['release_date'] ?? $item['first_air_date'] ?? null;

        $videos = Http::get("https://api.themoviedb.org/3/{$type}/{$id}/videos", [
            'api_key' => $apiKey,
            'language' => 'pt-BR',
        ])->json('results') ?? [];

        if (empty($videos)) {
            $videos = Http::get("https://api.themoviedb.org/3/{$type}/{$id}/videos", [
                'api_key' => $apiKey,
                'language' => 'en-US',
            ])->json('results') ?? [];
        }

        $credits = Http::get("https://api.themoviedb.org/3/{$type}/{$id}/credits", [
            'api_key' => $apiKey,
            'language' => 'pt-BR',
        ])->json() ?? ['cast' => [], 'crew' => []];

        $backdrop = !empty($item['backdrop_path'])
            ? "https://image.tmdb.org/t/p/original{$item['backdrop_path']}"
            : null;

        $poster = !empty($item['poster_path'])
            ? "https://image.tmdb.org/t/p/w500{$item['poster_path']}"
            : null;

        $rating = isset($item['vote_average'])
            ? number_format($item['vote_average'], 1)
            : '0.0';

        $crew = collect($credits['crew']);

        $director = $crew->firstWhere('job', 'Director')['name'] ?? '—';

        $writer = $crew->firstWhere('job', 'Writer')['name']
            ?? $crew->firstWhere('job', 'Screenplay')['name']
            ?? '—';

        $studios = collect($item['production_companies'] ?? [])
            ->pluck('name')
            ->take(2)
            ->implode(', ');

        $cast = collect($credits['cast'])
            ->take(10)
            ->map(fn($c) => [
                'id'        => $c['id'],
                'name'      => $c['name'],
                'character' => $c['character'] ?? null,
                'profile'   => $c['profile_path']
                    ? 'https://image.tmdb.org/t/p/w185' . $c['profile_path']
                    : null,
            ]);

        $firstWord = strtolower(explode(' ', trim(strtolower($title)))[0]);

        $videosCollection = collect($videos);

        $trailer = $videosCollection->first(function ($v) use ($firstWord) {
            $name = strtolower($v['name'] ?? '');
            return $v['type'] === 'Trailer'
                && ($v['official'] ?? false) === true
                && str_contains($name, $firstWord);
        })['key'] ?? null
        ?: ($videosCollection->skip(1)->firstWhere('type', 'Trailer')['key'] ?? null)
        ?: ($videosCollection->firstWhere('type', 'Trailer')['key'] ?? null);

        $runtime = $item['runtime'] ?? ($item['episode_run_time'][0] ?? null);
        $hours   = $runtime ? floor($runtime / 60) : null;
        $minutes = $runtime ? $runtime % 60 : null;

        $userData = Movie::where('user_id', Auth::id())
            ->where('tmdb_id', $id)
            ->first();

        return response()->json([
            'type'        => $type,
            'title'       => $title,
            'description' => $item['overview'] ?? '',
            'poster'      => $poster,
            'backdrop'    => $backdrop,
            'rating'      => $rating,
            'release'     => $release,
            'director'    => $director,
            'writer'      => $writer,
            'studios'     => $studios,
            'trailer'     => $trailer,
            'hours'       => $hours,
            'minutes'     => $minutes,
            'cast'        => $cast,
            'userData'    => $userData,
        ]);
    }

    public function destroy(Movie $movie)
    {
        if ($movie->user_id !== Auth::id()) {
            abort(403);
        }

        $movie->delete();

        return response()->json([
            'message' => 'Título removido com sucesso.',
        ]);
    }

    public function saveOrUpdate(Request $request)
    {
        $data = $request->validate([
            'tmdb_id'     => 'required',
            'title'       => 'required|string|max:255',
            'poster'      => 'nullable|string',
            'media_type'  => 'nullable|in:movie,tv',
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
            $movie = Movie::create([
                'user_id'     => $userId,
                'tmdb_id'     => $data['tmdb_id'],
                'title'       => $data['title'],
                'poster'      => $data['poster'],
                'media_type'  => $data['media_type'] ?? 'movie',
                'user_rating' => $data['user_rating'],
                'review'      => $data['review'],
            ]);
        }

        return response()->json([
            'message' => 'Avaliação salva com sucesso.',
            'movie'   => $movie,
        ]);
    }

    public function toggleFavorite(Movie $movie)
    {
        if ($movie->user_id !== Auth::id()) {
            abort(403);
        }

        $movie->is_favorite = !$movie->is_favorite;
        $movie->save();

        return response()->json([
            'is_favorite' => $movie->is_favorite,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Http::get('https://api.themoviedb.org/3/search/multi', [
            'api_key'  => config('services.tmdb.key'),
            'language' => 'pt-BR',
            'query'    => $query,
        ])->json()['results'] ?? [];

        return response()->json(
            collect($results)
                ->whereIn('media_type', ['movie', 'tv'])
                ->take(6)
                ->map(fn($m) => [
                    'id'         => $m['id'],
                    'title'      => $m['title'] ?? $m['name'] ?? '—',
                    'year'       => substr($m['release_date'] ?? $m['first_air_date'] ?? '', 0, 4),
                    'poster'     => $m['poster_path']
                        ? 'https://image.tmdb.org/t/p/w92' . $m['poster_path']
                        : null,
                    'media_type' => $m['media_type'],
                ])
                ->values()
        );
    }

    public function popular()
    {
        $apiKey = config('services.tmdb.key');

        $movies = Http::get('https://api.themoviedb.org/3/movie/popular', [
            'api_key'  => $apiKey,
            'language' => 'pt-BR',
        ])->json()['results'] ?? [];

        $shows = Http::get('https://api.themoviedb.org/3/tv/popular', [
            'api_key'  => $apiKey,
            'language' => 'pt-BR',
        ])->json()['results'] ?? [];

        $popular = collect($movies)
            ->map(fn($m) => [
                'id'           => $m['id'],
                'title'        => $m['title'],
                'poster'       => $m['poster_path']
                    ? 'https://image.tmdb.org/t/p/w185' . $m['poster_path']
                    : null,
                'backdrop'     => $m['backdrop_path']
                    ? 'https://image.tmdb.org/t/p/original' . $m['backdrop_path']
                    : null,
                'vote_average' => number_format($m['vote_average'], 1),
                'media_type'   => 'movie',
            ])
            ->merge(
                collect($shows)->map(fn($s) => [
                    'id'           => $s['id'],
                    'title'        => $s['name'],
                    'poster'       => $s['poster_path']
                        ? 'https://image.tmdb.org/t/p/w185' . $s['poster_path']
                        : null,
                    'backdrop'     => $s['backdrop_path']
                        ? 'https://image.tmdb.org/t/p/original' . $s['backdrop_path']
                        : null,
                    'vote_average' => number_format($s['vote_average'], 1),
                    'media_type'   => 'tv',
                ])
            )
            ->sortByDesc('vote_average')
            ->take(20)
            ->values();

        return response()->json($popular);
    }
}