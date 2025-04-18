@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-3 border-l-4 border-sarcastic-red text-base font-medium text-sarcastic-red bg-red-50 focus:outline-none focus:text-sarcastic-red focus:bg-red-100 focus:border-sarcastic-red transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
