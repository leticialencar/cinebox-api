<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('tmdb_id');
            $table->string('title');
            $table->string('genre')->nullable();
            $table->integer('release_year')->nullable();
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            
            $table->decimal('tmdb_rating', 3, 1)->nullable();
            $table->unsignedTinyInteger('user_rating')->nullable();
            $table->text('review')->nullable();
            
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
