<x-guest-layout>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6 text-cynical-gray text-center">Junte-se ao clube dos procrastinadores</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nome')" class="text-cynical-gray" />
                <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-cynical-gray" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Senha')" class="text-cynical-gray" />

                <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="text-cynical-gray" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-lazy-blue focus:ring-lazy-blue rounded-md shadow-sm"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Botão de registro mais visível -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-lazy-blue hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                    {{ __('Registrar Conta') }}
                </button>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a class="text-sm text-gray-600 hover:text-lazy-blue" href="{{ route('login') }}">
                    {{ __('Já tem uma conta? Faça login') }}
                </a>
            </div>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600 italic">Ao se registrar, você concorda em procrastinar suas tarefas de forma responsável e culpar o aplicativo por isso.</p>
        </div>
    </div>
</x-guest-layout>
