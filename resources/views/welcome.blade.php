<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineBox — Seu cinema pessoal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ openVideo: false }" class="bg-[#0b0b1f] text-white font-sans antialiased">

    <nav class="flex items-center justify-between px-4 md:px-10 py-4 md:py-5 border-b border-white/5">
        <a href="/">
            <img src="https://i.imgur.com/XPuoV4A.png"
            class="h-14 w-auto rounded-xl"
            alt="CineBox">
        </a>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}"
                class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg border border-white/15 text-gray-300 text-xs md:text-sm font-medium hover:border-white/30 transition">
                    Minha coleção
                </a>
            @else
                <a href="{{ route('login') }}"
                class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg border border-white/15 text-gray-300 text-xs md:text-sm font-medium hover:border-white/30 transition">
                    Entrar
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                    class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-[#8042e8] hover:bg-[#8042e8]/90 text-white text-xs md:text-sm font-semibold transition whitespace-nowrap">
                        Criar conta
                    </a>
                @endif
            @endauth
        </div>
    </nav>

    <section class="relative min-h-[580px] flex items-center overflow-hidden">
        <div class="absolute inset-0 flex gap-0.5 opacity-[0.12] pointer-events-none">
            @foreach(['bg-purple-700','bg-indigo-700','bg-teal-700','bg-amber-700','bg-pink-700','bg-blue-700','bg-violet-700','bg-emerald-700'] as $col)
                <div class="flex-1 flex flex-col gap-0.5">
                    <div class="flex-1 rounded {{ $col }}"></div>
                    <div class="flex-1 rounded {{ $loop->odd ? 'bg-indigo-800' : 'bg-purple-900' }}"></div>
                    <div class="flex-1 rounded {{ $col }}"></div>
                </div>
            @endforeach
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-[#0b0b1f] via-[#0b0b1f]/90 to-transparent"></div>

        <div class="relative z-10 px-5 md:px-16 py-12 md:py-20 max-w-2xl">
            <div class="inline-flex items-center gap-2 bg-purple-500/10 border border-purple-500/25 text-purple-400 text-xs font-bold px-4 py-1.5 rounded-full mb-8 tracking-widest uppercase">
                <span class="w-1.5 h-1.5 bg-purple-400 rounded-full"></span>
                Avaliação de filmes
            </div>

            <h1 class="text-3xl md:text-6xl font-extrabold leading-[1.08] tracking-tight mb-6">
                Registre cada<br>filme que você<br><span class="text-[#8042e8]">já assistiu.</span>
            </h1>

            <p class="text-gray-400 text-base md:text-lg leading-relaxed mb-8 md:mb-10 max-w-md">
                Crie sua coleção pessoal, avalie títulos, escreva resenhas
                e descubra o que assistir a seguir.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-8 md:mb-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-block px-8 py-4 rounded-xl bg-[#8042e8] hover:bg-[#8042e8]/90 text-white font-bold text-base transition-all hover:scale-[1.02] relative">
                        Ir para minha coleção
                    </a>
                @else
                    <a href="{{ route('register') }}"
                    class="w-full sm:w-auto text-center inline-block px-8 py-4 rounded-xl bg-[#8042e8] hover:bg-[#8042e8]/90 text-white font-bold text-base transition-all hover:scale-[1.02] relative">
                        Criar conta grátis
                    </a>
                    <a href="#" 
                    @click.prevent="openVideo = true"
                    class="w-full sm:w-auto text-center px-7 py-3.5 rounded-xl border border-white/15 text-gray-300 font-medium text-base hover:border-white/30 transition flex items-center justify-center gap-2">

                        <span class="w-5 h-5 bg-white/10 rounded-full flex items-center justify-center">
                            <svg width="8" height="8" viewBox="0 0 8 8" fill="white">
                                <path d="M2 1l5 3-5 3z"/>
                            </svg>
                        </span>

                        Ver como funciona
                    </a>
                @endauth
            </div>

            <div class="flex items-center gap-3">
                <div class="flex">
                    @foreach(['bg-purple-600','bg-teal-600','bg-amber-600','bg-pink-600'] as $c)
                        <div class="w-7 h-7 rounded-full border-2 border-[#0b0b1f] -ml-2 first:ml-0 {{ $c }} flex items-center justify-center text-[9px] font-bold"></div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500"><span class="text-gray-300 font-semibold">+500 cinéfilos</span> na experiência</p>
            </div>
        </div>
    </section>

    <div class="border-t border-white/5 mx-10"></div>

    <div id="popular"class="px-10 py-14">
        <div class="flex items-center justify-between mb-7">
            <h2 class="text-lg font-bold">Populares agora</h2>
            <span class="text-xs text-gray-600 uppercase tracking-widest">via TMDB</span>
        </div>

        <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2.5">
            @foreach(collect($popular)->sortByDesc('vote_average')->take(10) as $movie)
                @if(!empty($movie['poster_path']))
                    <a href="{{ route('movies.showFromApi', $movie['id']) }}"
                       class="relative rounded-lg overflow-hidden group block aspect-[2/3]">
                        <img src="https://image.tmdb.org/t/p/w185{{ $movie['poster_path'] }}"
                             class="w-full h-full object-cover transition duration-300 group-hover:brightness-60 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-2">
                            <span class="text-purple-400 text-[10px] font-bold">{{ number_format($movie['vote_average'], 1) }} ★</span>
                            <span class="text-white text-[10px] font-medium leading-tight mt-0.5 line-clamp-2">{{ $movie['title'] }}</span>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Features --}}
    <section id="features" class="px-10 py-20 bg-white/[0.015]">
        <div class="text-center mb-14">
            <p class="text-xs text-gray-600 uppercase tracking-widest font-semibold mb-3">Funcionalidades</p>
            <h2 class="text-3xl font-extrabold tracking-tight">Tudo que um <span class="text-[#8042e8]">cinéfilo</span> precisa</h2>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#8042e8" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Avaliações detalhadas</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Avalie filmes de 1 a 5 estrelas, escreva suas resenhas e registre tudo o que cada história te fez sentir.</p>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#8042e8" viewBox="0 0 16 16">
                    <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Coleção pessoal</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Organize todos os filmes que você assistiu. Filtre por gênero, nota ou favoritos com um clique.</p>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#8042e8" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Trailers integrados</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Assista aos trailers diretamente na página do filme, sem sair da plataforma, com integração ao YouTube.</p>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#8042e8" viewBox="0 0 16 16">
                    <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Lista de favoritos</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Marque os filmes que mais te marcaram e acesse seus favoritos sempre que quiser.</p>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#8042e8" viewBox="0 0 16 16">
                    <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm4 0v6h8V1zm8 8H4v6h8zM1 1v2h2V1zm2 3H1v2h2zM1 7v2h2V7zm2 3H1v2h2zm-2 3v2h2v-2zM15 1h-2v2h2zm-2 3v2h2V4zm2 3h-2v2h2zm-2 3v2h2v-2zm2 3h-2v2h2z"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Seu universo de filmes</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Tudo o que você assiste, avalia e salva em um só lugar.</p>
        </div>

        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-7 hover:border-[#8042e8]/30 transition-colors">
            <div class="w-11 h-11 bg-[#8042e8]/10 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="text-[#8042e8]" viewBox="0 0 16 16">
                    <path d="M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223"/>
                    <path d="M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                    <path d="M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                    <path d="M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-base mb-2">Informações completas</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Elenco, direção, sinopse e muito mais, com informações oficiais e sempre atualizadas.</p>
        </div>

    </div>

    </section>

    <section class="px-10 py-24 text-center relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-48 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <h2 class="text-4xl font-extrabold tracking-tight mb-4 relative">Pronto para começar?</h2>
        <p class="text-gray-500 text-base mb-10 relative">Crie sua conta grátis e comece a registrar seus filmes hoje.</p>
        @auth
            <a href="{{ url('/dashboard') }}"
               class="inline-block px-8 py-4 rounded-xl bg-[#8042e8] hover:bg-[#8042e8]/90 text-white font-bold text-base transition-all hover:scale-[1.02] relative">
                Ir para minha coleção
            </a>
        @else
            <a href="{{ route('register') }}"
               class="inline-block px-8 py-4 rounded-xl bg-[#8042e8] hover:bg-[#8042e8]/90 text-white font-bold text-base transition-all hover:scale-[1.02] relative">
                Criar minha conta
            </a>
        @endauth
    </section>

    <div x-show="openVideo"
        class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
        x-transition
        @click.self="openVideo = false">

        <div class="w-full max-w-4xl aspect-video bg-black rounded-xl overflow-hidden relative border border-white/10">

            <button @click="openVideo = false; $refs.video.src = $refs.video.src"
                    class="absolute top-3 right-3 text-white bg-black/60 rounded-full w-8 h-8 flex items-center justify-center z-10">
                ✕
            </button>

            <iframe
                x-ref="video"
                class="w-full h-full"
                src="https://player.vimeo.com/video/1185974496?autoplay=1&muted=1&loop=1&background=1"
                frameborder="0"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen>
            </iframe>

        </div>
    </div>

    <x-footer />

</body>
</html>