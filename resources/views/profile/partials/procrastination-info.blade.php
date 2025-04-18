<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Seu Perfil de Procrastinação') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Veja seu nível de procrastinação e conquistas duvidosas.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @php
            $user = auth()->user();
            $tasks = $user->tasks;
            $completedTasks = $tasks->where('is_completed', true)->count();
            $failedTasks = $tasks->where('is_failed', true)->count();
            $pendingTasks = $tasks->where('is_completed', false)->where('is_failed', false)->count();
            $totalTasks = $tasks->count();
            $overdueTasks = $tasks->where('is_completed', false)->where('is_failed', false)
                ->filter(function($task) {
                    return $task->due_date && $task->due_date->isPast();
                })->count();

            // Calculate level
            $level = 1;
            $levelName = 'Procrastinador Iniciante';
            $levelDescription = 'Você mal começou a evitar suas responsabilidades.';
            $progress = 0;
            $tasksForNextLevel = 5;

            if ($completedTasks < 5) {
                $level = 1;
                $levelName = 'Procrastinador Iniciante';
                $levelDescription = 'Você mal começou a evitar suas responsabilidades.';
                $progress = min(100, ($completedTasks / 5) * 100);
                $tasksForNextLevel = 5 - $completedTasks;
            } elseif ($completedTasks < 15) {
                $level = 2;
                $levelName = 'Procrastinador Casual';
                $levelDescription = 'Você está aprendendo a arte de adiar, mas ainda tem muito a melhorar.';
                $progress = min(100, (($completedTasks - 5) / 10) * 100);
                $tasksForNextLevel = 15 - $completedTasks;
            } elseif ($completedTasks < 30) {
                $level = 3;
                $levelName = 'Procrastinador Dedicado';
                $levelDescription = 'Você já domina as técnicas básicas de procrastinação produtiva.';
                $progress = min(100, (($completedTasks - 15) / 15) * 100);
                $tasksForNextLevel = 30 - $completedTasks;
            } elseif ($completedTasks < 50) {
                $level = 4;
                $levelName = 'Mestre Procrastinador';
                $levelDescription = 'Sua habilidade em completar tarefas no último segundo é impressionante.';
                $progress = min(100, (($completedTasks - 30) / 20) * 100);
                $tasksForNextLevel = 50 - $completedTasks;
            } else {
                $level = 5;
                $levelName = 'Lenda da Procrastinação';
                $levelDescription = 'Você transcendeu o tempo e o espaço. Completa tarefas enquanto procrastina.';
                $progress = 100;
                $tasksForNextLevel = 0;
            }
        @endphp

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-sarcastic-red rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ $level }}
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $levelName }}</h3>
                    <p class="text-gray-600">{{ $levelDescription }}</p>
                </div>
            </div>

            <div class="mb-4">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Progresso para o próximo nível</span>
                    <span class="text-sm font-medium text-gray-700">{{ round($progress) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-sarcastic-red h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                </div>
                @if($tasksForNextLevel > 0)
                    <p class="text-sm text-gray-600 mt-1">Faltam {{ $tasksForNextLevel }} tarefas concluídas para o próximo nível</p>
                @else
                    <p class="text-sm text-gray-600 mt-1">Você atingiu o nível máximo! Agora pode procrastinar em paz.</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-3xl font-bold text-gray-800">{{ $completedTasks }}</div>
                    <div class="text-sm text-gray-600">Tarefas Concluídas</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-3xl font-bold text-gray-800">{{ $pendingTasks }}</div>
                    <div class="text-sm text-gray-600">Tarefas Pendentes</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-3xl font-bold text-gray-800">{{ $failedTasks }}</div>
                    <div class="text-sm text-gray-600">Tarefas Falhas</div>
                </div>
            </div>

            <h4 class="text-lg font-semibold text-gray-800 mb-3">Suas Conquistas</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @php
                    $achievements = [];

                    // Completion achievements
                    if ($completedTasks >= 1) {
                        $achievements[] = [
                            'name' => 'Primeiro Passo',
                            'description' => 'Completou sua primeira tarefa. Quem diria?',
                            'icon' => '🏆'
                        ];
                    }

                    if ($completedTasks >= 10) {
                        $achievements[] = [
                            'name' => 'Produtividade Suspeita',
                            'description' => 'Completou 10 tarefas. Está realmente procrastinando?',
                            'icon' => '🔥'
                        ];
                    }

                    if ($completedTasks >= 25) {
                        $achievements[] = [
                            'name' => 'Máquina de Produtividade',
                            'description' => 'Completou 25 tarefas. Você é um unicórnio produtivo!',
                            'icon' => '⚡'
                        ];
                    }

                    // Failure achievements
                    if ($failedTasks >= 1) {
                        $achievements[] = [
                            'name' => 'Realista',
                            'description' => 'Admitiu sua primeira falha. Honestidade é o primeiro passo.',
                            'icon' => '👀'
                        ];
                    }

                    if ($failedTasks >= 5) {
                        $achievements[] = [
                            'name' => 'Mestre da Desistência',
                            'description' => 'Falhou em 5 tarefas. Pelo menos você é consistente em algo.',
                            'icon' => '🤷‍♂️'
                        ];
                    }

                    // Overdue achievements
                    if ($overdueTasks >= 3) {
                        $achievements[] = [
                            'name' => 'Senhor do Tempo',
                            'description' => 'Tem 3 tarefas atrasadas. O tempo é apenas um conceito para você.',
                            'icon' => '⏰'
                        ];
                    }
                @endphp

                @if(count($achievements) > 0)
                    @foreach($achievements as $achievement)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl mr-3">{{ $achievement['icon'] }}</div>
                            <div>
                                <div class="font-medium">{{ $achievement['name'] }}</div>
                                <div class="text-sm text-gray-600">{{ $achievement['description'] }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-gray-600 italic">Nenhuma conquista ainda. Continue procrastinando de forma produtiva!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>