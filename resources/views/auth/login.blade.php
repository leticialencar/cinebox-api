<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm text-gray-400 mb-2">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
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
                autocomplete="current-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mb-6">
            <label class="inline-flex items-center gap-2 cursor-pointer relative group">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-white/20 bg-white/5 text-[#8042e8] focus:ring-[#8042e8] focus:ring-offset-0"
                >

                <span class="text-sm text-gray-400">
                    Continuar conectado
                </span>

                <span class="absolute left-0 -top-9 hidden group-hover:block bg-[#0b0b1f] border border-white/10 text-white text-xs px-3 py-1 rounded-lg shadow-xl whitespace-nowrap">
                    Mantém você logado neste dispositivo por mais tempo
                </span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-[#8042e8] hover:text-[#6f36d6] transition">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="w-full py-3 rounded-xl text-white font-semibold bg-[#8042e8] hover:bg-[#6f36d6] hover:scale-[1.02] transition-all duration-200"
        >
            Entrar
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-[#8042e8] hover:text-[#6f36d6] transition">
                Criar conta
            </a>
        </p>
    </form>
</x-guest-layout>