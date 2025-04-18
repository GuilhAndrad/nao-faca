<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Não-Faça: Sua Lista de Procrastinação</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cynical-gray': '#2d3748',
                        'sarcastic-red': '#e53e3e',
                        'lazy-blue': '#4299e1',
                        'procrastinate-yellow': '#ecc94b',
                    }
                }
            }
        }
    </script>
    @livewireStyles

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f3f4f6;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e2e8f0' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        h1, h2, h3 {
            font-family: 'Bitter', serif;
        }
    </style>
</head>
<body>
    <div class="py-8 px-4 max-w-6xl mx-auto">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-cynical-gray">
                <span class="text-sarcastic-red">Não</span>-Faça
            </h1>
            <p class="text-gray-600 italic mt-2">Porque listar tarefas já é chato, pelo menos vamos rir do desespero.</p>
        </div>

        @livewire('task-manager')
    </div>

    @livewireScripts
</body>
</html>