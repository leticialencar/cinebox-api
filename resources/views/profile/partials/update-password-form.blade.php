<section>
    <header>
        <h2 class="text-lg font-bold text-white">
            {{ __('Atualizar Senha') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Use uma senha longa e aleatória para manter sua conta segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm text-gray-400 mb-2">
                {{ __('Senha atual') }}
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm text-gray-400 mb-2">
                {{ __('Nova senha') }}
            </label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            />

            <div id="password-checklist"
                class="hidden opacity-0 transition-all duration-300 mt-2 mb-2">

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

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm text-gray-400 mb-2">
                {{ __('Confirmar nova senha') }}
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="••••••••"
            />

            <p id="password-match-message" class="text-sm text-red-400 mt-2 hidden"></p>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-1">
            <button
                id="submit-btn"
                type="submit"
                disabled
                class="px-6 py-3 rounded-xl bg-[#8042e8] hover:bg-[#6f36d6] hover:scale-[1.02] text-white text-sm font-semibold transition-all duration-200"
            >
                {{ __('Salvar') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-500"
                >{{ __('Salvo!') }}</p>
            @endif
        </div>
    </form>
</section>