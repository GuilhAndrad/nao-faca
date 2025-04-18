@props(['pendingTasks', 'editingTaskId', 'editingTaskName', 'editingTaskPriority', 'editingTaskDueDate'])

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <h2 class="text-lg sm:text-xl font-semibold mb-4 text-cynical-gray flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        Tarefas Pendentes
    </h2>

    @if(count($pendingTasks) == 0)
        <p class="text-gray-500 italic text-sm">Nenhuma tarefa pendente? Você é um unicórnio ou está mentindo?</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($pendingTasks as $task)
                <li class="py-4">
                    @if($editingTaskId === $task->id)
                        <div class="space-y-3">
                            <input wire:model="editingTaskName" type="text" class="w-full p-3 border border-gray-300 rounded text-base">
                            @error('editingTaskName') <span class="text-sarcastic-red text-sm">{{ $message }}</span> @enderror

                            <select wire:model="editingTaskPriority" class="w-full p-3 border border-gray-300 rounded text-base">
                                <option value="1">Baixa Prioridade</option>
                                <option value="2">Média Prioridade</option>
                                <option value="3">Alta Prioridade</option>
                            </select>

                            <input wire:model="editingTaskDueDate" type="date" class="w-full p-3 border border-gray-300 rounded text-base">

                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 mt-3">
                                <button wire:click="updateTask" class="bg-sarcastic-red hover:bg-red-600 text-white py-2 px-4 rounded text-base w-full sm:w-auto">
                                    Salvar
                                </button>
                                <button wire:click="cancelEditing" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded text-base w-full sm:w-auto">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex items-start space-x-3 mb-3 sm:mb-0">
                                <!-- Removed the circle button here -->

                                <div>
                                    <p class="font-medium text-gray-700 text-base">
                                        {{ $task->name }}
                                    </p>

                                    <div class="text-xs text-gray-500 mt-1 space-y-1">
                                        @if($task->due_date)
                                            <div class="{{ $task->is_overdue ? 'text-sarcastic-red' : '' }}">
                                                <span class="font-medium">Prazo:</span> {{ $task->due_date->format('d/m/Y') }}
                                                @if($task->is_overdue)
                                                    <span class="italic">(Atrasada - Isso aqui já virou um museu?)</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="italic">Sem prazo (como se isso fosse ajudar)</div>
                                        @endif

                                        <div>
                                            <span class="font-medium">Prioridade:</span>
                                            @if($task->priority == 3)
                                                <span class="text-sarcastic-red">Alta</span>
                                            @elseif($task->priority == 2)
                                                <span class="text-procrastinate-yellow">Média</span>
                                            @else
                                                <span>Baixa</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <button wire:click="toggleComplete({{ $task->id }})" class="text-green-500 hover:text-green-700 p-2 bg-green-50 rounded-full" title="Marcar como concluída">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>

                                <button wire:click="markAsFailed({{ $task->id }})" class="text-sarcastic-red hover:text-red-700 p-2 bg-red-50 rounded-full" title="Marcar como falha">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <button wire:click="startEditing({{ $task->id }})" class="text-lazy-blue hover:text-blue-700 p-2 bg-blue-50 rounded-full" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>

                                <button wire:click="deleteTask({{ $task->id }})" class="text-gray-500 hover:text-gray-700 p-2 bg-gray-50 rounded-full" title="Deletar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        <!-- After the task list but before closing the main div -->
        @if(count($pendingTasks) > 0)
            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                {{ $pendingTasks->links() }}
            </div>
        @endif
    @endif
</div>