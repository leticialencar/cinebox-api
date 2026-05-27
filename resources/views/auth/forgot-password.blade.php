<x-guest-layout>
    <p class="mb-6 text-sm text-gray-400 leading-relaxed">
        Esqueceu sua senha? Sem problema. Informe seu e-mail abaixo e enviaremos um link para você criar uma nova senha.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
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
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-600 transition"
                placeholder="seu@email.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button
                type="submit"
                class="w-full py-3 rounded-xl text-white font-semibold transition-all duration-200 hover:scale-[1.02]"
                style="background-color: #8042e8;"
                onmouseover="this.style.backgroundColor='#6f36d6'"
                onmouseout="this.style.backgroundColor='#8042e8'"
            >
                Enviar link de redefinição
            </button>
        </div>

    </form>
</x-guest-layout>