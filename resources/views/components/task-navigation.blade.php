@props(['activeTab', 'tasks'])

<div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
    <div class="flex flex-wrap">
        <button
            wire:click="$set('activeTab', 'add')"
            type="button"
            style="{{ $activeTab === 'add' ? 'background-color: #e53e3e; color: white;' : '' }}"
            class="flex-1 py-3 px-1 sm:px-4 text-center transition-colors duration-200 ease-in-out {{ $activeTab === 'add' ? 'bg-sarcastic-red text-white font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline">Adicionar</span>
            </div>
        </button>

        <button
            wire:click="$set('activeTab', 'pending')"
            type="button"
            style="{{ $activeTab === 'pending' ? 'background-color: #ecc94b; color: #2d3748;' : '' }}"
            class="flex-1 py-3 px-1 sm:px-4 text-center transition-colors duration-200 ease-in-out {{ $activeTab === 'pending' ? 'bg-procrastinate-yellow text-gray-800 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="hidden sm:inline">Pendentes</span>
                @if(isset($tasks) && $tasks->where('is_completed', false)->where('is_failed', false)->count() > 0)
                    <span class="ml-1 bg-white text-xs font-medium px-2 py-0.5 rounded-full" style="color: #ecc94b;">
                        {{ $tasks->where('is_completed', false)->where('is_failed', false)->count() }}
                    </span>
                @endif
            </div>
        </button>

        <button
            wire:click="$set('activeTab', 'completed')"
            type="button"
            style="{{ $activeTab === 'completed' ? 'background-color: #48bb78; color: white;' : '' }}"
            class="flex-1 py-3 px-1 sm:px-4 text-center transition-colors duration-200 ease-in-out {{ $activeTab === 'completed' ? 'bg-green-500 text-white font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="hidden sm:inline">Concluídas</span>
                @if(isset($tasks) && $tasks->where('is_completed', true)->count() > 0)
                    <span class="ml-1 bg-white text-xs font-medium px-2 py-0.5 rounded-full" style="color: #48bb78;">
                        {{ $tasks->where('is_completed', true)->count() }}
                    </span>
                @endif
            </div>
        </button>

        <button
            wire:click="$set('activeTab', 'failed')"
            type="button"
            style="{{ $activeTab === 'failed' ? 'background-color: #e53e3e; color: white;' : '' }}"
            class="flex-1 py-3 px-1 sm:px-4 text-center transition-colors duration-200 ease-in-out {{ $activeTab === 'failed' ? 'bg-sarcastic-red text-white font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="hidden sm:inline">Falhas</span>
                @if(isset($tasks) && $tasks->where('is_failed', true)->count() > 0)
                    <span class="ml-1 bg-white text-xs font-medium px-2 py-0.5 rounded-full" style="color: #e53e3e;">
                        {{ $tasks->where('is_failed', true)->count() }}
                    </span>
                @endif
            </div>
        </button>

        <button
            wire:click="$set('activeTab', 'stats')"
            type="button"
            style="{{ $activeTab === 'stats' ? 'background-color: #3182ce; color: white;' : '' }}"
            class="flex-1 py-3 px-1 sm:px-4 text-center transition-colors duration-200 ease-in-out {{ $activeTab === 'stats' ? 'bg-lazy-blue text-white font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 sm:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="hidden sm:inline">Estatísticas</span>
            </div>
        </button>
    </div>
</div>