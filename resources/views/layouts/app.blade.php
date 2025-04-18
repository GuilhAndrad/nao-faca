<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f7f9fc;
            }

            .mobile-nav-item {
                @apply block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium transition duration-150 ease-in-out;
            }

            .mobile-nav-active {
                @apply border-sarcastic-red text-sarcastic-red bg-red-50 focus:outline-none focus:text-sarcastic-red focus:bg-red-100 focus:border-sarcastic-red;
            }

            .mobile-nav-inactive {
                @apply border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300;
            }

            .card {
                @apply bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300;
            }
        </style>

        <!-- Add this custom style to hide the mobile bottom menu -->
        <style>
            @media (max-width: 640px) {
                .fixed.bottom-0.left-0.right-0.bg-white.border-t.border-gray-200.z-50,
                .sm\:hidden.fixed.bottom-0 {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
