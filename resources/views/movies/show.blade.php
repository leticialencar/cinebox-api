<x-app-layout>
    <div class="min-h-screen bg-[#0b0b1f] text-white">

        @php
            $releaseYear = $movie['release_date'] ?? null;

            $ratingFixed = isset($movie['rating'])
                ? number_format((float) $movie['rating'], 1, '.', '')
                : (isset($movie['vote_average'])
                    ? number_format((float) $movie['vote_average'], 1, '.', '')
                    : '0.0');

            $runtime = $movie['runtime'] ?? null;
            $hours   = $runtime ? intdiv($runtime, 60) : null;
            $minutes = $runtime ? $runtime % 60 : null;
        @endphp

        <div class="relative w-full h-[75vh] overflow-hidden hidden md:block">
            <img
                src="{{ $movie['backdrop'] ?? '' }}"
                class="absolute inset-0 w-full h-full object-cover scale-110 blur-sm opacity-40"
            >

            @if(session('success'))
                <div id="alert"
                    class="fixed top-6 right-6 z-50 p-4 rounded-lg bg-green-600 text-white text-sm font-semibold shadow-lg transform translate-x-20 opacity-0 transition-all duration-500">
                    {{ session('success') }}
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-b from-[#0b0b1f]/20 via-[#0b0b1f]/80 to-[#0b0b1f]"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 h-full flex items-end pb-16">
                <div class="flex flex-row gap-10 items-end">
                    <div class="w-72 rounded-2xl overflow-hidden shadow-2xl border border-white/10 translate-y-10 flex-shrink-0">
                        <img src="{{ $movie['poster'] ?? '' }}" class="w-full h-full object-cover">
                    </div>
                    <div class="max-w-2xl text-left">
                        <h1 class="text-6xl font-bold mb-4">{{ $movie['title'] ?? 'Sem título' }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                            <span>{{ $ratingFixed }}/10</span>
                            <span>{{ $releaseYear ? substr($releaseYear, 0, 4) : '—' }}</span>
                            @if (!empty($runtime))
                                <span>{{ $hours }}h {{ $minutes }}min</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- mobile --}}
        <div class="md:hidden relative w-full overflow-hidden">
        @if(session('success'))
            <div id="alert-mobile"  {{-- ← trocar para alert-mobile --}}
                class="fixed top-6 right-6 z-50 p-4 rounded-lg bg-green-600 text-white text-sm font-semibold shadow-lg transform translate-x-20 opacity-0 transition-all duration-500">
                {{ session('success') }}
            </div>
        @endif

            <div class="absolute inset-0 h-56 overflow-hidden">
                <img
                    src="{{ $movie['backdrop'] ?? '' }}"
                    class="w-full h-full object-cover blur-sm opacity-30 scale-110"
                >
                <div class="absolute inset-0 bg-gradient-to-b from-[#0b0b1f]/30 to-[#0b0b1f]"></div>
            </div>

            <div class="relative z-10 flex flex-col items-center pt-10 pb-6 px-6">
                <div class="w-40 rounded-2xl overflow-hidden shadow-2xl border border-white/10 mb-5">
                    <img src="{{ $movie['poster'] ?? '' }}" class="w-full h-full object-cover">
                </div>

                <h1 class="text-2xl font-bold text-center mb-3 leading-tight">
                    {{ $movie['title'] ?? 'Sem título' }}
                </h1>

                <div class="flex items-center justify-center gap-4 text-sm text-gray-300">
                    <span>{{ $ratingFixed }}/10</span>
                    <span>{{ $releaseYear ? substr($releaseYear, 0, 4) : '—' }}</span>
                    @if (!empty($runtime))
                        <span>{{ $hours }}h {{ $minutes }}min</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-16 grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-10">

            <div class="lg:col-span-2">

                <h2 class="text-xl font-semibold mb-4 text-purple-400">Sinopse</h2>

                <p class="text-gray-300 leading-relaxed mb-10">
                    {{ $movie['overview'] ?? 'Sinopse não disponível.' }}
                </p>

                {{-- info cards --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-6 mb-8 md:mb-12">

                    <div class="bg-white/5 border border-white/10 p-4 md:p-5 rounded-xl">
                        <p class="text-gray-400 text-xs md:text-sm">Diretor</p>
                        <p class="font-semibold text-sm md:text-base">{{ $movie['director'] ?? '—' }}</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-4 md:p-5 rounded-xl">
                        <p class="text-gray-400 text-xs md:text-sm">Roteiro</p>
                        <p class="font-semibold text-sm md:text-base">{{ $movie['writer'] ?? '—' }}</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-4 md:p-5 rounded-xl col-span-2 md:col-span-1">
                        <p class="text-gray-400 text-xs md:text-sm">Estúdio</p>
                        <p class="font-semibold text-sm md:text-base">{{ $movie['studios'] ?? '—' }}</p>
                    </div>

                </div>

                {{-- cast --}}
                <h2 class="text-xl font-semibold mb-6 text-purple-400">
                    Elenco Principal
                </h2>

                <div x-data class="relative group">

                    <button
                        @click="$refs.cast.scrollBy({ left: -280, behavior: 'smooth' })"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1 z-10
                            w-8 h-8 rounded-full bg-[#0b0b1f]/80 border border-white/10
                            text-gray-400 hover:text-white hover:border-white/25
                            flex items-center justify-center
                            opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </button>

                    <div x-ref="cast" class="flex gap-3 md:gap-6 overflow-x-auto pb-4 md:pb-6 no-scrollbar scroll-smooth">

                    @forelse (collect($movie['credits']['cast'] ?? [])->take(10) as $actor)
                        @php
                            $actorName = $actor['name'] ?? 'Desconhecido';
                            $character = $actor['character'] ?? '—';
                            $profile = !empty($actor['profile_path'])
                                ? "https://image.tmdb.org/t/p/w185{$actor['profile_path']}"
                                : "https://ui-avatars.com/api/?name=" . urlencode($actorName) . "&background=8042e8&color=fff&size=185";
                        @endphp

                        <div class="min-w-[80px] md:min-w-[100px] text-center flex-shrink-0">
                            <img
                                src="{{ $profile }}"
                                class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-2 md:mb-3 rounded-full object-cover border border-white/10 hover:border-[#8042e8]/50 transition"
                            >
                            <p class="text-xs md:text-sm font-semibold leading-tight">{{ $actorName }}</p>
                            <p class="text-[10px] md:text-xs text-gray-500 mt-0.5">{{ $character }}</p>
                        </div>

                    @empty
                        <p class="text-gray-500 text-sm">Elenco não disponível.</p>
                    @endforelse

                </div>

                    <button
                        @click="$refs.cast.scrollBy({ left: 280, behavior: 'smooth' })"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1 z-10
                            w-8 h-8 rounded-full bg-[#0b0b1f]/80 border border-white/10
                            text-gray-400 hover:text-white hover:border-white/25
                            flex items-center justify-center
                            opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>

                </div>

                @if ($trailer)
                    <h2 class="text-xl font-semibold mb-4 text-purple-400">
                        Trailer
                    </h2>

                    <div class="aspect-video w-full">
                        <iframe
                            class="w-full h-full rounded-xl"
                            src="https://www.youtube.com/embed/{{ $trailer }}"
                            allowfullscreen
                        >
                        </iframe>
                    </div>
                @endif

            </div>

            <div class="space-y-6">

                {{-- actions --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

                    <div class="space-y-4">

                        @if ($userData)

                            <form method="POST" action="{{ route('movies.toggleFavorite', $userData->id) }}">
                                @csrf
                                @method('PATCH')

                                <button
                                    class="w-full py-3 rounded-2xl transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-lg
                                    {{ $userData->is_favorite
                                        ? 'bg-red-600 hover:bg-red-700'
                                        : 'bg-[#8042e8] hover:bg-[#8042e8]/90' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="{{ $userData->is_favorite ? 'white' : 'currentColor' }}"
                                    >
                                        <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                                    </svg>

                                    {{ $userData->is_favorite ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}
                                </button>
                            </form>

                            <button
                                id="openModal"
                                class="w-full py-3 rounded-2xl border border-[#8042e8] text-purple-400 hover:bg-purple-600/20 transition-all duration-200 flex items-center justify-center gap-2 font-semibold"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-pencil-square"
                                    viewBox="0 0 16 16"
                                >
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                                Editar detalhes
                            </button>

                            {{-- Form separado, sem botão próprio --}}
                            <form method="POST" action="{{ route('movies.destroy', $userData->id) }}" id="deleteMovieForm">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button
                                id="openDeleteModal"
                                class="w-full py-3 rounded-2xl bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-2 font-semibold"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-trash3-fill"
                                    viewBox="0 0 16 16"
                                >
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                </svg>
                                Remover da coleção
                            </button>

                        @else

                            <form method="POST" action="{{ route('movies.storeFromApi') }}">
                                @csrf

                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <input type="hidden" name="title" value="{{ $movie['title'] }}">
                                <input type="hidden" name="release_year" value="{{ substr($release, 0, 4) }}">
                                <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                                <input type="hidden" name="poster" value="{{ $movie['poster'] ?? '' }}">

                                <button class="w-full bg-[#8042e8] hover:bg-[#8042e8]/90 py-3 rounded-xl mb-3">
                                    + Adicionar à coleção
                                </button>

                                <p class="text-gray-400 text-sm mt-2 text-center">
                                    Esse filme ainda não faz parte da sua coleção.
                                    Adicione para acompanhar suas avaliações e novidades.
                                </p>
                            </form>

                        @endif

                    </div>
                </div>

                {{-- rating --}}
                <div class="bg-white/5 border border-white/10 rounded-2xl p-6">

                    <p class="text-gray-400 text-sm mb-2">Sua avaliação</p>

                    @if ($userData && !empty($userData->user_rating))

                        @php
                            $starValue = $userData->user_rating / 2;
                        @endphp

                        <div class="flex gap-1 text-2xl">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($starValue >= $i)
                                    <span style="color: #9b5de5;">★</span>
                                @elseif ($starValue >= $i - 0.5)
                                    <span class="relative inline-block" style="color: #4b4b6b;">
                                        ★
                                        <span class="absolute inset-0 overflow-hidden w-1/2" style="color: #9b5de5;">★</span>
                                    </span>
                                @else
                                    <span style="color: #4b4b6b;">★</span>
                                @endif
                            @endfor
                        </div>

                        <p class="text-sm text-gray-400 mt-2">
                            {{ number_format($starValue, 1) }}/5
                        </p>

                    @else

                        <p class="text-gray-500 text-sm">Ainda não avaliado</p>

                    @endif

                </div>
        </div>

        {{-- Modal de avaliação --}}
        <div id="ratingModal" class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-[#0b0b1f] border border-white/10 rounded-2xl p-8 max-w-lg w-full mx-4 relative shadow-2xl">

                <h2 class="text-2xl font-semibold mb-2 text-purple-400">Sua Avaliação</h2>
                <p class="text-gray-400 text-sm mb-6">
                    Compartilhe sua experiência cinematográfica com a comunidade.
                </p>

                <form method="POST" action="{{ route('movies.saveOrUpdate') }}">
                    @csrf

                    <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                    <input type="hidden" name="title" value="{{ $movie['title'] }}">
                    <input type="hidden" name="poster" value="{{ $movie['poster'] }}">

                    <div class="mb-6">
                        <label class="block text-sm text-gray-400 mb-2">Sua nota</label>

                        <div id="starContainer" class="flex gap-1 text-4xl">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star relative cursor-pointer" data-value="{{ $i }}">
                                    <span class="half absolute top-0 left-0 overflow-hidden text-purple-500 w-0">★</span>
                                    <span class="full text-gray-400">★</span>
                                </span>
                            @endfor
                        </div>

                        <input
                            type="hidden"
                            name="user_rating"
                            id="ratingInput"
                            value="{{ $userData->user_rating ?? 0 }}"
                        >
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm text-gray-400 mb-2">Comentário</label>

                        <textarea
                            id="reviewInput"
                            name="review"
                            maxlength="2000"
                            rows="5"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-purple-600 transition resize-none"
                            placeholder="O que você achou do filme?"
                        >{{ $userData->review ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button
                            type="button"
                            id="closeModal"
                            class="px-6 py-3 rounded-2xl border border-purple-500 text-purple-400 hover:bg-purple-600/20 transition-all duration-200 font-semibold"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-3 rounded-2xl bg-[#8042e8] hover:bg-[#8042e8]/90 hover:scale-[1.02] transition-all duration-200 font-semibold flex items-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                                <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                                <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                            </svg>
                            Salvar
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Modal de confirmação de remoção --}}
        <div id="deleteModal" class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-[#0b0b1f] border border-white/10 rounded-2xl p-8 max-w-md w-full mx-4 relative shadow-2xl">

                <h2 class="text-2xl font-semibold mb-2 text-purple-400">Remover da coleção?</h2>
                <p class="text-gray-400 text-sm mb-6">
                    Essa ação não pode ser desfeita.
                </p>

                <p class="text-gray-300 text-sm leading-relaxed mb-8">
                    Se você remover <strong class="text-white">{{ $movie['title'] ?? 'este filme' }}</strong> da sua coleção,
                    todos os dados associados serão apagados permanentemente, incluindo sua
                    <span class="text-purple-400">avaliação</span> e
                    <span class="text-purple-400">comentários</span>.
                </p>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4">
                    <button
                        id="cancelDeleteModal"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-purple-500 text-purple-400 hover:bg-purple-600/20 transition-all duration-200 font-semibold"
                    >
                        Cancelar
                    </button>
                    <button
                        id="confirmDelete"
                        class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:scale-[1.02] transition-all duration-200 font-semibold flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                        </svg>
                        Sim, remover
                    </button>
                </div>

            </div>
        </div>

        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/js/modal.js',
            'resources/js/deleteModal.js'
        ])

    </div>
</x-app-layout>