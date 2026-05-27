<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CineBox') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0b0b1f]">

        <div class="min-h-screen flex flex-col justify-center items-center px-6 sm:px-0">

            <div class="mb-8">
                <a href="/" class="flex justify-center">
                    <img 
                        src="https://i.imgur.com/XPuoV4A.png"
                        alt="CineBox"
                        class="w-40 sm:w-64 md:w-72 lg:w-80 h-auto rounded-xl"
                    >
                </a>
            </div>

            <div class="w-full max-w-sm sm:max-w-md px-5 py-7 bg-white/5 border border-white/10 shadow-xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

        </div>

        <x-footer-minimal />

    </body>
</html>