<nav x-data="{ open: false }" class="flex items-center justify-between px-10 py-5 border-b border-white/5 bg-[#0b0b1f]">

    <a href="{{ route('dashboard') }}">
        <img src="https://i.imgur.com/XPuoV4A.png" class="h-14 w-auto rounded-xl" alt="CineBox">
    </a>

    @auth
    <div class="hidden sm:flex flex-1 max-w-md mx-8 relative" x-data="searchBar()" @click.outside="close()">

        <div class="group flex items-center w-full bg-[#14142b]/80 backdrop-blur-md border border-white/10 rounded-2xl px-3 py-2.5 transition-all duration-300 focus-within:border-[#8042e8]/60 focus-within:shadow-[0_0_0_2px_rgba(128,66,232,0.15)]">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="text-gray-400 group-focus-within:text-[#8042e8] transition duration-300 flex-shrink-0"
                viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            <input
                type="text"
                x-model="query"
                @input.debounce.300ms="search()"
                @keydown.enter="goToFirst()"
                @keydown.escape="close()"
                placeholder="Buscar filmes..."
                class="bg-transparent w-full ml-3 text-sm text-white placeholder-gray-500 outline-none border-none focus:outline-none focus:ring-0 appearance-none"
                style="appearance: none; -webkit-appearance: none; box-shadow: none;"
            >
            <button x-show="query" @click="query = ''; results = []"
                class="ml-2 w-5 h-5 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-500 hover:text-white transition flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </button>
        </div>

        <div x-show="results.length > 0"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute top-full mt-2 w-full bg-[#0f0d24] border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/60 z-50"
             style="display:none">

            <div class="px-3 py-2 border-b border-white/5">
                <p class="text-[10px] text-gray-600 uppercase tracking-widest font-semibold">Resultados</p>
            </div>

            <template x-for="movie in results" :key="movie.id">
                <a :href="`/movies/tmdb/${movie.id}`"
                   class="flex items-center gap-3 px-3 py-2.5 hover:bg-white/[0.05] transition group mx-1 my-0.5 rounded-xl">
                    <div class="relative flex-shrink-0">
                        <img x-show="movie.poster" :src="movie.poster" class="w-8 h-11 object-cover rounded-lg border border-white/10">
                        <div x-show="!movie.poster" class="w-8 h-11 bg-white/5 rounded-lg border border-white/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="text-gray-700" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-200 group-hover:text-white transition truncate" x-text="movie.title"></p>
                        <p class="text-xs text-gray-600 mt-0.5" x-text="movie.year"></p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor"
                         class="text-gray-700 group-hover:text-[#8042e8] transition flex-shrink-0" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </a>
            </template>

            <div class="px-3 py-2 border-t border-white/5">
                <p class="text-[10px] text-gray-700 text-center">Enter para ir ao primeiro resultado</p>
            </div>
        </div>

    </div>
    @endauth

    <div class="hidden sm:flex items-center gap-3">
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-white/15 text-gray-300 text-sm font-medium hover:border-[#8042e8]/50 hover:text-purple-300 transition-all duration-200">
                @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}"
                        class="w-6 h-6 rounded-full object-cover border border-white/10">
                @else
                    <span class="w-6 h-6 rounded-full bg-[#8042e8]/30 flex items-center justify-center text-[10px] font-bold text-purple-300">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                @endif
                {{ Auth::user()->name }}
                <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-[#13132b] border border-white/10 rounded-xl shadow-xl overflow-hidden z-50"
                 style="display: none;">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-4 py-3 text-sm text-gray-400 hover:text-white hover:bg-white/5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4"/>
                    </svg>
                    Perfil
                </a>
                <div class="border-t border-white/5"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-gray-400 hover:text-red-400 hover:bg-white/5 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- mobile --}}
    <div class="sm:hidden">
        <button @click="open = !open" class="p-2 rounded-lg border border-white/10 text-gray-400 hover:text-white hover:border-white/20 transition">
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div :class="{'flex': open, 'hidden': !open}"
         class="hidden absolute top-[76px] left-0 right-0 flex-col bg-[#0f0f23] border-b border-white/5 px-6 py-4 gap-1 sm:hidden z-50">

        <div class="flex items-center gap-3 pb-4 mb-2 border-b border-white/5">
            @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}"
                    class="w-8 h-8 rounded-full object-cover border border-white/10">
            @else
                <span class="w-8 h-8 rounded-full bg-[#8042e8]/30 flex items-center justify-center text-xs font-bold text-purple-300">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            @endif
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="relative mb-2 overflow-visible" x-data="searchBar()" @click.outside="close()">
            <div class="group flex items-center w-full bg-[#14142b]/80 border border-white/10 rounded-2xl px-3 py-2.5 focus-within:border-[#8042e8]/60">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                    class="text-gray-400 group-focus-within:text-[#8042e8] transition flex-shrink-0"
                    viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                <input
                    type="text"
                    x-model="query"
                    @input.debounce.300ms="search()"
                    @keydown.enter="goToFirst()"
                    @keydown.escape="close()"
                    placeholder="Buscar filmes..."
                    class="bg-transparent w-full ml-3 text-sm text-white placeholder-gray-500 outline-none border-none focus:outline-none focus:ring-0 appearance-none"
                    style="appearance: none; -webkit-appearance: none; box-shadow: none;"
                >
                <button x-show="query" @click="query = ''; results = []"
                    class="ml-2 w-5 h-5 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-gray-500 hover:text-white transition flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </button>
            </div>

            <div x-show="results.length > 0"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute top-full mt-2 w-full bg-[#0f0d24] border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/60 z-50"
                style="display:none">
                <div class="px-3 py-2 border-b border-white/5">
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest font-semibold">Resultados</p>
                </div>
                <template x-for="movie in results" :key="movie.id">
                    <a :href="`/movies/tmdb/${movie.id}`"
                        class="flex items-center gap-3 px-3 py-2.5 hover:bg-white/[0.05] transition group mx-1 my-0.5 rounded-xl">
                        <div class="relative flex-shrink-0">
                            <img x-show="movie.poster" :src="movie.poster" class="w-8 h-11 object-cover rounded-lg border border-white/10">
                            <div x-show="!movie.poster" class="w-8 h-11 bg-white/5 rounded-lg border border-white/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="text-gray-700" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                    <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-200 group-hover:text-white transition truncate" x-text="movie.title"></p>
                            <p class="text-xs text-gray-600 mt-0.5" x-text="movie.year"></p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor"
                            class="text-gray-700 group-hover:text-[#8042e8] transition flex-shrink-0" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </a>
                </template>
                <div class="px-3 py-2 border-t border-white/5">
                    <p class="text-[10px] text-gray-700 text-center">Enter para ir ao primeiro resultado</p>
                </div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4"/>
            </svg>
            Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-gray-400 hover:text-red-400 hover:bg-white/5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Sair
            </button>
        </form>
    </div>

</nav>