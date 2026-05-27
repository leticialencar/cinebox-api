<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-white">
            {{ __('Excluir Conta') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Após excluir sua conta, todos os dados serão permanentemente removidos. Salve qualquer informação importante antes de prosseguir.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-2xl bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:scale-[1.02] transition-all duration-200 font-semibold flex items-center gap-2"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>
        {{ __('Excluir Conta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#0f0f23]">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white">
                {{ __('Tem certeza que deseja excluir sua conta?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                {{ __('Após excluir sua conta, todos os dados serão permanentemente removidos. Digite sua senha para confirmar.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="block text-sm text-gray-400 mb-2">
                    {{ __('Senha') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-purple-500 text-purple-400 hover:bg-purple-600/20 transition-all duration-200 font-semibold"
                >
                    {{ __('Cancelar') }}
                </button>

                <button
                    type="submit"
                    class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:scale-[1.02] transition-all duration-200 font-semibold flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>
                    {{ __('Excluir Conta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>