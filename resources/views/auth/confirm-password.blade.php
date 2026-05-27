<x-guest-layout>
    <p class="mb-6 text-sm text-gray-400 leading-relaxed">
        Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-6">
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

        <button
            type="submit"
            class="w-full py-3 rounded-xl text-white font-semibold bg-[#8042e8] hover:bg-[#6f36d6] hover:scale-[1.02] transition-all duration-200"
        >
            Confirmar
        </button>

    </form>
</x-guest-layout>