<x-guest-layout>
    <p class="mb-6 text-sm text-gray-400 leading-relaxed">
        Obrigado por se cadastrar! Antes de começar, verifique seu e-mail clicando no link que enviamos para você. Caso não tenha recebido, podemos reenviar.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="flex items-start gap-3 p-4 rounded-xl border border-[#8042e8]/30 bg-[#8042e8]/10 text-[#8042e8] text-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="mt-0.5 shrink-0">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <span>Um novo link de verificação foi enviado para o seu e-mail.</span>
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="py-3 px-6 rounded-xl bg-[#8042e8] text-white text-sm font-semibold hover:bg-[#6f36d6] hover:scale-[1.02] transition-all duration-200"
            >
                Reenviar e-mail de verificação
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-300 transition">
                Sair
            </button>
        </form>
    </div>
</x-guest-layout>