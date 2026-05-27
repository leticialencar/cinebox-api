<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'genre',
        'release_year',
        'description',
        'tmdb_rating', 
        'user_rating', 
        'review',    
        'is_favorite',
        'user_id', 
        'tmdb_id', 
        'poster',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'release_year' => 'integer',
        'tmdb_rating' => 'decimal:1',
        'user_rating' => 'integer',
    ];
}