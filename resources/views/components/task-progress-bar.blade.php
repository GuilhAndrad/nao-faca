@props(['tasks', 'progressMessage'])

@php
    $completed = $tasks->where('is_completed', true)->count();
    $total = count($tasks);
    $percentage = $total > 0 ? ($completed / $total) * 100 : 0;
@endphp

<div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <div class="mb-2 flex justify-between text-sm text-gray-600">
        <span>{{ $completed }} de {{ $total }} tarefas</span>
        <span>{{ number_format($percentage, 0) }}%</span>
    </div>

    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="h-2.5 rounded-full transition-all duration-500"
             style="width: {{ $percentage }}%; background-color: {{ $percentage > 0 ? '#48bb78' : '#e53e3e' }};">
        </div>
    </div>

    <div class="mt-2 text-sm text-gray-500 italic text-center">
        {{ $progressMessage }}
    </div>
</div>