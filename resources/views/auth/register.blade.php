<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm text-gray-400 mb-2">Nome</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="Seu nome"
            >
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm text-gray-400 mb-2">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="seu@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm text-gray-400 mb-2">Senha</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm text-gray-400 mb-2">Confirmar senha</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            >

            <p id="password-match-message"
                class="text-sm mt-2 hidden !text-red-500">
            </p>
        
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div id="password-checklist"
            class="hidden opacity-0 transition-all duration-300 mt-2 mb-8">

            <p class="text-sm text-gray-500 mb-2">
                Sua senha deve conter:
            </p>

            <ul class="space-y-2 text-sm">

                <li id="rule-length" class="flex items-center gap-3 text-gray-500">
                    <span class="icon flex items-center justify-center w-4 h-4">
                        <span class="dot w-2 h-2 rounded-full bg-gray-400"></span>
                    </span>
                    Mínimo de 8 caracteres
                </li>

                <li id="rule-uppercase" class="flex items-center gap-3 text-gray-500">
                    <span class="icon flex items-center justify-center w-4 h-4">
                        <span class="dot w-2 h-2 rounded-full bg-gray-400"></span>
                    </span>
                    Pelo menos 1 letra maiúscula
                </li>

                <li id="rule-number" class="flex items-center gap-3 text-gray-500">
                    <span class="icon flex items-center justify-center w-4 h-4">
                        <span class="dot w-2 h-2 rounded-full bg-gray-400"></span>
                    </span>
                    Pelo menos 1 número
                </li>

                <li id="rule-symbol" class="flex items-center gap-3 text-gray-500">
                    <span class="icon flex items-center justify-center w-4 h-4">
                        <span class="dot w-2 h-2 rounded-full bg-gray-400"></span>
                    </span>
                    Pelo menos 1 símbolo
                </li>

            </ul>

        </div>

        <button
            id="submit-btn"
            type="submit"
            disabled
            class="w-full py-3 rounded-xl text-white font-semibold bg-[#8042e8] hover:bg-[#6f36d6] hover:scale-[1.02] transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:scale-100"
        >
            Criar conta
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="text-[#8042e8] hover:text-[#6f36d6] transition">
                Entrar
            </a>
        </p>
    </form>
</x-guest-layout>