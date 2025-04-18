<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
            <div class="flex flex-col items-start">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Perfil') }}
                </h2>
                <a href="{{ url()->previous() }}" class="mt-2 px-3 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </a>
            </div>
            <button onclick="toggleAccountSettings()" id="account-settings-toggle"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300 transition flex items-center justify-center">
                <span id="toggle-text">Mostrar Configurações de Conta</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Profile Information (Always Visible) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('profile.partials.procrastination-info')
                </div>
            </div>

            <!-- Account Settings (Hidden by Default) -->
            <div id="account-settings" class="space-y-6 hidden">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for toggling account settings -->
    <script>
        function toggleAccountSettings() {
            const settingsSection = document.getElementById('account-settings');
            const toggleText = document.getElementById('toggle-text');

            if (settingsSection.classList.contains('hidden')) {
                settingsSection.classList.remove('hidden');
                toggleText.textContent = 'Ocultar Configurações de Conta';
            } else {
                settingsSection.classList.add('hidden');
                toggleText.textContent = 'Mostrar Configurações de Conta';
            }
        }
    </script>
</x-app-layout>
