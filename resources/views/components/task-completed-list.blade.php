@props(['completedTasks'])

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Tarefas Concluídas
    </h2>

    @if(count($completedTasks) == 0)
        <p class="text-gray-500 italic text-sm">Nenhuma tarefa concluída? Por que não me surpreendo?</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($completedTasks as $task)
                <li class="py-4 opacity-70">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div class="flex items-start space-x-3 mb-3 sm:mb-0">
                            <button wire:click="toggleComplete({{ $task->id }})" class="flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <div>
                                <p class="font-medium line-through text-gray-500 text-base">
                                    {{ $task->name }}
                                </p>

                                <div class="text-xs text-gray-500 mt-1">
                                    <div>
                                        <span class="font-medium">Concluída em:</span>
                                        {{ $task->updated_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button wire:click="deleteTask({{ $task->id }})" class="text-gray-500 hover:text-gray-700 p-2 bg-gray-50 rounded-full self-end sm:self-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Pagination -->
        <!-- After the task list but before closing the main div -->
        @if(count($completedTasks) > 0)
            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                {{ $completedTasks->links() }}
            </div>
        @endif
    @endif
</div>