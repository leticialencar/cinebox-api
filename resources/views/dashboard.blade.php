<x-app-layout>
   <div class="min-h-screen bg-[#0b0b1f] text-white">

        @php $featured = $popular[0] ?? null; @endphp

        @if($featured && !empty($featured['backdrop_path']))
            <div class="relative h-[85vh] md:h-[85vh] w-full overflow-hidden">

                <img src="https://image.tmdb.org/t/p/original{{ $featured['backdrop_path'] }}"
                     class="absolute inset-0 w-full h-full object-cover object-top scale-105">

                <div class="absolute inset-0 
                    bg-gradient-to-t 
                    from-[#0b0b1f] via-[#0b0b1f]/80 via-40%
                    to-transparent">
                </div>

                <div class="relative z-10 flex flex-col justify-end h-full px-5 md:px-16 pb-10 md:pb-16 max-w-3xl">
                    <span class="uppercase text-xs md:text-sm tracking-widest text-purple-400 mb-3 md:mb-4">
                        Em destaque
                    </span>

                    <h1 class="text-2xl md:text-6xl font-extrabold mb-3 md:mb-6 leading-tight">
                        {{ $featured['title'] }}
                    </h1>

                    <p class="text-gray-300 text-sm md:text-lg mb-5 md:mb-8 line-clamp-2 md:line-clamp-3">
                        {{ $featured['overview'] }}
                    </p>

                    <div class="flex gap-3 md:gap-6">
                        <form method="POST" action="{{ route('movies.storeFromApi') }}">
                            @csrf
                            <input type="hidden" name="tmdb_id" value="{{ $featured['id'] }}">
                            <input type="hidden" name="title" value="{{ $featured['title'] }}">
                            <input type="hidden" name="release_year" value="{{ substr($featured['release_date'] ?? '',0,4) }}">
                            <input type="hidden" name="description" value="{{ $featured['overview'] }}">
                            <input type="hidden" name="poster" value="https://image.tmdb.org/t/p/w500{{ $featured['poster_path'] ?? '' }}">

                            <button class="bg-[#8042e8] hover:bg-[#8042e8]/90 px-4 md:px-6 py-2.5 md:py-3 rounded-xl text-sm md:text-lg shadow-lg transition">
                                + Adicionar à coleção
                            </button>
                        </form>

                        <a href="{{ route('movies.showFromApi', $featured['id']) }}"
                           class="bg-white/10 hover:bg-white/20 px-4 md:px-6 py-2.5 md:py-3 rounded-xl text-sm md:text-lg transition">
                            Mais detalhes
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="px-6 md:px-10 mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Total na coleção</h3>
                </div>
                <p class="text-3xl font-bold mt-2">{{ $movies->count() }}</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16m0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Filmes populares hoje</h3>
                </div>
                <p class="text-3xl font-bold mt-2">{{ count($popular) }}</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
                <div class="flex items-center gap-2 text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                    </svg>
                    <h3 class="text-sm text-gray-400">Último adicionado</h3>
                </div>
                <p class="text-lg font-semibold mt-2">
                    {{ $movies->first()->title ?? 'Nenhum ainda' }}
                </p>
            </div>

        </div>

        {{-- CTA Coleção --}}
        <div class="px-6 md:px-10 mt-20 mb-16">
            <div class="relative rounded-3xl overflow-hidden border border-[#8042e8]/20 bg-gradient-to-r from-[#8042e8]/20 via-[#1a1545] to-[#0f0c29] p-10 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#8042e8]/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-[#8042e8]/10 rounded-full blur-2xl"></div>
                </div>
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Organize sua biblioteca</h2>
                    <p class="text-gray-400 text-sm md:text-base max-w-md">
                        Veja todos os filmes que você adicionou, filtre por avaliação, favoritos e muito mais.
                    </p>
                </div>
                <a href="{{ route('movies.index') }}"
                    class="relative z-10 flex-shrink-0 bg-[#8042e8] hover:bg-[#8042e8]/90 px-8 py-4 rounded-2xl text-base font-bold shadow-lg shadow-[#8042e8]/30 transition flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                    </svg>
                    Ir para minha coleção
                </a>
            </div>
        </div>

        {{-- Carrossel --}}
        <div class="px-5 md:px-10 mt-12 md:mt-20 relative">
            <h2 class="text-xl md:text-3xl font-bold mb-5 md:mb-8">Populares no momento</h2>

            <button onclick="scrollCarousel(-1)"
                class="hidden md:flex absolute left-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
                </svg>
            </button>

            <button onclick="scrollCarousel(1)"
                class="hidden md:flex absolute right-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753"/>
                </svg>
            </button>

            <div id="carousel" class="flex gap-3 md:gap-6 overflow-x-auto scroll-smooth no-scrollbar pb-4">

                @foreach($popular as $movie)
                    <div class="min-w-[120px] md:min-w-[160px] group relative rounded-xl overflow-hidden hover:z-10">

                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-105 group-hover:brightness-75">

                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300
                                    flex flex-col justify-end p-2 md:p-3
                                    bg-gradient-to-t from-black via-black/70 to-transparent">

                            <h3 class="text-[10px] md:text-xs font-semibold mb-1.5 md:mb-2 line-clamp-2">
                                {{ $movie['title'] }}
                            </h3>

                            <form method="POST" action="{{ route('movies.storeFromApi') }}">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <input type="hidden" name="title" value="{{ $movie['title'] }}">
                                <input type="hidden" name="release_year" value="{{ substr($movie['release_date'] ?? '',0,4) }}">
                                <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                                <input type="hidden" name="poster" value="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}">

                                <div class="flex flex-col gap-1.5 md:gap-2">
                                    <button class="w-full bg-[#8042e8] hover:bg-[#8042e8]/90 py-1 rounded text-[10px] md:text-xs transition">
                                        + Adicionar
                                    </button>
                                    <a href="{{ route('movies.showFromApi', $movie['id']) }}"
                                       class="w-full block text-center bg-white/10 hover:bg-white/20 py-1 rounded text-[10px] md:text-xs transition">
                                        Detalhes
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

        @if(!empty($topRated))
        <div class="px-5 md:px-10 mt-12 md:mt-20 relative">
            <h2 class="text-xl md:text-3xl font-bold mb-5 md:mb-8">Talvez você curta</h2>

            <button onclick="scrollTopRated(-1)"
                class="hidden md:flex absolute left-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
                </svg>
            </button>

            <button onclick="scrollTopRated(1)"
                class="hidden md:flex absolute right-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753"/>
                </svg>
            </button>

            <div id="toprated-carousel" class="flex gap-3 md:gap-6 overflow-x-auto scroll-smooth no-scrollbar pb-4">
                @foreach($topRated as $movie)
                    <div class="min-w-[120px] md:min-w-[160px] group relative rounded-xl overflow-hidden hover:z-10">

                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}"
                            class="w-full h-full object-cover transition duration-300 group-hover:scale-105 group-hover:brightness-75">

                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300
                                    flex flex-col justify-end p-2 md:p-3
                                    bg-gradient-to-t from-black via-black/70 to-transparent">

                            <h3 class="text-[10px] md:text-xs font-semibold mb-1.5 md:mb-2 line-clamp-2">
                                {{ $movie['title'] }}
                            </h3>

                            <form method="POST" action="{{ route('movies.storeFromApi') }}">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <input type="hidden" name="title" value="{{ $movie['title'] }}">
                                <input type="hidden" name="release_year" value="{{ substr($movie['release_date'] ?? '',0,4) }}">
                                <input type="hidden" name="description" value="{{ $movie['overview'] }}">
                                <input type="hidden" name="poster" value="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}">

                                <div class="flex flex-col gap-1.5 md:gap-2">
                                    <button class="w-full bg-[#8042e8] hover:bg-[#8042e8]/90 py-1 rounded text-[10px] md:text-xs transition">
                                        + Adicionar
                                    </button>
                                    <a href="{{ route('movies.showFromApi', $movie['id']) }}"
                                    class="w-full block text-center bg-white/10 hover:bg-white/20 py-1 rounded text-[10px] md:text-xs transition">
                                        Detalhes
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(!empty($upcoming))
        <div class="px-5 md:px-10 mt-16 mb-10 relative">
            <h2 class="text-xl md:text-3xl font-bold mb-6">Em breve nos cinemas</h2>

            <button onclick="scrollUpcoming(-1)"
                class="hidden md:flex absolute left-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M10 12.796V3.204L4.519 8zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753"/>
                </svg>
            </button>

            <button onclick="scrollUpcoming(1)"
                class="hidden md:flex absolute right-2 top-[55%] -translate-y-1/2 z-20 bg-black/60 hover:bg-black/80 p-3 rounded-full backdrop-blur items-center justify-center hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-white" viewBox="0 0 16 16">
                    <path d="M6 12.796V3.204L11.481 8zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753"/>
                </svg>
            </button>

            <div id="upcoming-carousel" class="flex gap-4 overflow-x-auto scroll-smooth no-scrollbar pb-4">
                @foreach($upcoming as $movie)
                    @if(!empty($movie['backdrop_path']))
                    <div class="relative flex-shrink-0 w-[320px] md:w-[480px] h-[180px] md:h-[270px] rounded-2xl overflow-hidden group">

                        <img src="https://image.tmdb.org/t/p/w780{{ $movie['backdrop_path'] }}"
                            class="absolute inset-0 w-full h-full object-cover object-center transition duration-500 group-hover:scale-105 group-hover:brightness-75">

                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b1f]/95 via-[#0b0b1f]/40 to-transparent"></div>

                        <div class="relative z-10 flex flex-col justify-end h-full p-4 md:p-6">
                            <span class="self-start text-[8px] md:text-[9px] text-white mb-2 px-1.5 py-[2px] bg-[#8042e8] rounded">
                                {{ \Carbon\Carbon::parse($movie['release_date'])->translatedFormat('d \d\e F \d\e Y') }}
                            </span>
                            <h3 class="text-sm md:text-lg font-extrabold mb-1 line-clamp-1">{{ $movie['title'] }}</h3>
                            <p class="text-gray-400 text-[10px] md:text-xs line-clamp-2 mb-3">{{ $movie['overview'] }}</p>

                            <a href="{{ route('movies.showFromApi', $movie['id']) }}"
                            class="self-start bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg text-[10px] md:text-xs font-semibold transition">
                                Mais detalhes
                            </a>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <style>
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

    </div>
</x-app-layout>