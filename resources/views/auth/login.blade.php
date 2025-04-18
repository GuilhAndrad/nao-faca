<x-guest-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-cynical-gray text-center">Bem-vindo de volta, procrastinador</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-cynical-gray" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Senha')" class="text-cynical-gray" />

                <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-lazy-blue shadow-sm focus:ring-lazy-blue" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Lembrar de mim (para continuar procrastinando depois)') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lazy-blue" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha? Típico.') }}
                    </a>
                @endif

                <x-primary-button class="ml-3 bg-lazy-blue hover:bg-blue-600">
                    {{ __('Entrar') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">Ainda não tem uma conta? <a href="{{ route('register') }}" class="text-lazy-blue hover:underline">Registre-se</a> e comece a não fazer suas tarefas agora mesmo.</p>
        </div>
    </div>
</x-guest-layout>
