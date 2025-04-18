@props(['failedTasks'])

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        Tarefas Falhas
    </h2>

    @if(count($failedTasks) == 0)
        <p class="text-gray-500 italic text-sm">Nenhuma tarefa falha? Ou você é muito bom ou muito covarde para admitir.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($failedTasks as $task)
                <li class="py-4 opacity-70">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start space-x-3 mb-3 sm:mb-0">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-sarcastic-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>

                            <div>
                                <p class="font-medium line-through text-sarcastic-red text-base">
                                    {{ $task->name }}
                                </p>

                                <div class="text-xs text-gray-500 mt-1">
                                    <div>
                                        <span class="font-medium">Falhou em:</span>
                                        {{ $task->updated_at->format('d/m/Y') }}
                                    </div>
                                    @if($task->due_date)
                                        <div>
                                            <span class="font-medium">Prazo original:</span>
                                            {{ $task->due_date->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button wire:click="toggleComplete({{ $task->id }})" class="text-green-500 hover:text-green-700 p-2 bg-green-50 rounded-full" title="Marcar como concluída">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>

                            <!-- Botão de marcar como concluída removido -->
                            <!-- Botão de restaurar removido -->
                            <button wire:click="deleteTask({{ $task->id }})" class="text-gray-500 hover:text-gray-700 p-2 bg-gray-50 rounded-full" title="Deletar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Pagination -->
        <!-- After the task list but before closing the main div -->
        @if(count($failedTasks) > 0)
            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                {{ $failedTasks->links() }}
            </div>
        @endif
    @endif
</div>