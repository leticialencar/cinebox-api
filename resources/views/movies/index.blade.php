<x-app-layout>
    <div class="min-h-screen bg-[#0b0b1f] text-white">

        <div class="px-6 md:px-10 pt-12 pb-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">

            <div>
                <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 px-3 py-1.5 rounded-lg transition mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                    </svg>
                    Voltar ao início
                </a>
                <h1 class="text-2xl font-bold">Minha Coleção</h1>
                <p class="text-gray-500 mt-1 text-sm">
                    {{ $movies->count() }} {{ $movies->count() == 1 ? 'filme na sua coleção' : 'filmes na sua coleção' }}
                </p>
            </div>

                <div class="relative w-full md:w-72">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16"
                        fill="currentColor"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"
                        viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Buscar na coleção..."
                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#8042e8] focus:border-transparent transition placeholder-gray-600 hover:border-white/20"
                    >
                </div>

            </div>

            <div class="flex flex-wrap gap-3 mt-8">

                <div class="flex gap-2 flex-wrap">
                    <button onclick="filterBy('all')" data-filter="all"
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-[#8042e8]/40 bg-[#8042e8]/10 text-[#a060ff]">
                        Todos
                    </button>
                    <button onclick="filterBy('rated')" data-filter="rated"
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-[#a060ff]">
                        Avaliados
                    </button>
                    <button onclick="filterBy('unrated')" data-filter="unrated"
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-[#a060ff]">
                        Não avaliados
                    </button>
                    <button onclick="filterBy('favorite')" data-filter="favorite"
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-[#a060ff]">
                        ♥ Favoritos
                    </button>
                </div>

                <div class="hidden md:block w-px bg-white/10 mx-1"></div>

                <select id="sortSelect"
                    class="bg-white/[0.03] border border-white/10 rounded-lg px-4 py-2 text-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition cursor-pointer hover:border-white/20">
                    <option value="recent">Mais recentes</option>
                    <option value="title">Título A–Z</option>
                    <option value="rating">Melhor avaliação</option>
                    <option value="year">Ano de lançamento</option>
                </select>

                <div class="ml-auto flex gap-2">
                    <button id="gridView" onclick="setView('grid')"
                        class="view-btn p-2.5 rounded-lg border border-[#8042e8]/40 bg-[#8042e8]/10 text-[#a060ff] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
                        </svg>
                    </button>
                    <button id="listView" onclick="setView('list')"
                        class="view-btn p-2.5 rounded-lg border border-white/10 bg-white/[0.03] text-gray-500 hover:border-[#8042e8]/30 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div class="px-6 md:px-10 pb-16">

            @if($movies->isEmpty())
                <div class="flex flex-col items-center justify-center py-32 text-center">
                    <div class="w-20 h-20 rounded-full bg-[#8042e8]/10 border border-[#8042e8]/20 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#8042e8" viewBox="0 0 16 16">
                            <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2">Sua coleção está vazia</h2>
                    <p class="text-gray-500 text-sm max-w-xs leading-relaxed">
                        Explore os filmes populares na página inicial e adicione os que você já assistiu ou deseja assistir.
                    </p>
                    <a href="{{ route('dashboard') }}"
                        class="mt-6 bg-[#8042e8] hover:bg-[#8042e8]/90 px-6 py-3 rounded-xl text-sm font-semibold transition hover:scale-[1.02]">
                        Explorar filmes
                    </a>
                </div>

            @else

                <div id="movieGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-3">
                    @foreach ($movies as $movie)
                        <div class="movie-card group relative rounded-xl overflow-hidden hover:z-10 cursor-pointer"
                            data-title="{{ strtolower($movie->title) }}"
                            data-rated="{{ $movie->user_rating ? 'true' : 'false' }}"
                            data-favorite="{{ $movie->is_favorite ? 'true' : 'false' }}"
                            data-year="{{ $movie->release_year }}"
                            data-rating="{{ $movie->user_rating ?? 0 }}">

                            <a href="{{ route('movies.showFromApi', $movie->tmdb_id ?? $movie->id) }}">
                                <div class="aspect-[2/3] relative bg-white/[0.03]">
                                    @if($movie->poster)
                                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}"
                                            class="w-full h-full object-cover transition duration-300 group-hover:scale-105 group-hover:brightness-50">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="text-gray-700" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    @if($movie->is_favorite)
                                        <div class="absolute top-2 right-2 w-6 h-6 rounded-full bg-black/60 flex items-center justify-center backdrop-blur-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#e85d7a" viewBox="0 0 16 16">
                                                <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300
                                                flex flex-col justify-end p-3
                                                bg-gradient-to-t from-black via-black/70 to-transparent">
                                        <h3 class="text-xs font-semibold mb-1 line-clamp-2">{{ $movie->title }}</h3>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-400">{{ $movie->release_year }}</span>
                                            @if($movie->user_rating)
                                                <div class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" fill="#8042e8" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <span class="text-xs text-[#a060ff]">{{ number_format($movie->user_rating / 2, 1) }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-600">Sem nota</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div id="movieList" class="hidden flex-col gap-2">
                    @foreach ($movies as $movie)
                        <a href="{{ route('movies.showFromApi', $movie->tmdb_id ?? $movie->id) }}"
                            class="movie-card flex items-center gap-5 bg-white/[0.03] border border-white/10 rounded-2xl p-4 hover:bg-white/[0.06] hover:border-[#8042e8]/30 transition group"
                            data-title="{{ strtolower($movie->title) }}"
                            data-rated="{{ $movie->user_rating ? 'true' : 'false' }}"
                            data-favorite="{{ $movie->is_favorite ? 'true' : 'false' }}"
                            data-year="{{ $movie->release_year }}"
                            data-rating="{{ $movie->user_rating ?? 0 }}">

                            <div class="w-12 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-white/5">
                                @if($movie->poster)
                                    <img src="{{ $movie->poster }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold truncate">{{ $movie->title }}</h3>
                                    @if($movie->is_favorite)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="#e85d7a" viewBox="0 0 16 16" class="flex-shrink-0">
                                            <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm mt-0.5">{{ $movie->release_year ?? '—' }}</p>
                            </div>

                            <div class="flex-shrink-0 text-right">
                                @if($movie->user_rating)
                                    @php $stars = $movie->user_rating / 2; @endphp
                                    <div class="flex items-center gap-1.5 justify-end">
                                        <div class="flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($stars >= $i)
                                                    <span style="color:#8042e8" class="text-sm">★</span>
                                                @elseif ($stars >= $i - 0.5)
                                                    <span style="color:#8042e8;opacity:0.4" class="text-sm">★</span>
                                                @else
                                                    <span class="text-gray-700 text-sm">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-[#a060ff] font-semibold">{{ number_format($stars, 1) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-600 text-sm">Sem nota</span>
                                @endif
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor"
                                class="text-gray-700 group-hover:text-[#8042e8] transition flex-shrink-0"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>

                        </a>
                    @endforeach
                </div>

                <div id="emptySearch" class="hidden flex-col items-center justify-center py-24 text-center">
                    <p class="text-gray-500 text-sm">Nenhum filme encontrado com os filtros aplicados.</p>
                    <button onclick="resetFilters()" class="mt-4 text-[#a060ff] text-sm hover:underline">Limpar filtros</button>
                </div>

            @endif
        </div>

    </div>

</x-app-layout>