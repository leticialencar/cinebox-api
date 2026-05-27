<section>
    <header>
        <h2 class="text-lg font-bold text-white">
            {{ __('Informações do Perfil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('Atualize o nome e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        {{-- Avatar --}}
        <div x-data="{ preview: null }">
            <label class="block text-sm text-gray-400 mb-3">{{ __('Foto de perfil') }}</label>

            <div class="flex items-center gap-5">

                {{-- Preview --}}
                <div class="relative flex-shrink-0">
                    <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-white/10 bg-white/5 flex items-center justify-center">
                        <img
                            x-show="preview"
                            :src="preview"
                            class="w-full h-full object-cover"
                        >
                        @if($user->avatar)
                            <img
                                x-show="!preview"
                                src="{{ $user->avatar }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <span x-show="!preview" class="text-2xl font-bold text-purple-300">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Botão de upload --}}
                <div class="flex flex-col gap-2">
                    <label for="avatar"
                           class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 hover:border-white/20 text-sm text-gray-400 hover:text-white transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                        </svg>
                        Escolher foto
                    </label>
                    <p class="text-xs text-gray-600">JPG, PNG ou GIF. Máx. 2MB.</p>
                </div>

                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="
                        const file = $event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = e => preview = e.target.result;
                            reader.readAsDataURL(file);
                        }
                    "
                >
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- Nome --}}
        <div>
            <label for="name" class="block text-sm text-gray-400 mb-2">
                {{ __('Nome') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="Seu nome"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- E-mail --}}
        <div>
            <label for="email" class="block text-sm text-gray-400 mb-2">
                {{ __('E-mail') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#8042e8] transition"
                placeholder="seu@email.com"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-500">
                        {{ __('Seu e-mail ainda não foi verificado.') }}
                        <button form="send-verification" class="text-[#8042e8] hover:text-[#6f36d6] underline text-sm transition focus:outline-none">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-emerald-400 font-medium">
                            {{ __('Um novo link de verificação foi enviado para o seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-1">
            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-[#8042e8] hover:bg-[#6f36d6] hover:scale-[1.02] text-white text-sm font-semibold transition-all duration-200"
            >
                {{ __('Salvar') }}
            </button>

            @if (session('status') === 'profile-updated')
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