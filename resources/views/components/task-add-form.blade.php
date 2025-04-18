@props(['newTaskName', 'newTaskPriority', 'newTaskDueDate'])

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md mb-4 sm:mb-6">
    <h2 class="text-lg sm:text-xl font-semibold mb-4 text-cynical-gray flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Nova Tarefa
        <span class="text-xs sm:text-sm font-normal text-gray-500 ml-2 italic">(que você provavelmente não vai fazer)</span>
    </h2>

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nome da tarefa</label>
            <input wire:model="newTaskName" type="text" placeholder="Seja realista..."
                class="w-full p-3 border border-gray-300 rounded text-base">
            @error('newTaskName') <span class="text-sarcastic-red text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prioridade</label>
            <select wire:model="newTaskPriority" class="w-full p-3 border border-gray-300 rounded text-base">
                <option value="1">Baixa (Vamos ser honestos)</option>
                <option value="2">Média (Talvez faça)</option>
                <option value="3">Alta (Quem você está enganando?)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prazo</label>
            <input
                wire:model="newTaskDueDate"
                type="date"
                min="{{ date('Y-m-d') }}"
                class="w-full p-3 border border-gray-300 rounded text-base"
                placeholder="Escolha uma data futura">
            <p class="text-xs text-gray-500 mt-1 italic">Escolha uma data no futuro (como se isso fosse ajudar)</p>
        </div>

        <button
            wire:click="addTask"
            style="background-color: #e53e3e !important; color: white !important; display: flex !important; width: 100% !important; position: relative !important; z-index: 50 !important;"
            class="py-3 px-4 rounded items-center justify-center text-base font-medium">
            <svg style="width: 1.25rem !important; height: 1.25rem !important; margin-right: 0.5rem !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Adicionar à Lista de Sonhos
        </button>
    </div>
</div>