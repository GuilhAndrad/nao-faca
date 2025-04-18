@props(['tasks', 'stats'])

<div class="grid grid-cols-1 gap-4 sm:gap-6">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <!-- Subabas de navegação -->
        <div x-data="{ activeTab: 'level' }" class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex justify-center -mb-px" aria-label="Tabs">
                    <div class="flex space-x-8 overflow-x-auto">
                        <button @click="activeTab = 'level'"
                                :class="{ 'border-lazy-blue text-lazy-blue': activeTab === 'level', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'level' }"
                                class="whitespace-nowrap py-3 px-3 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Nível
                        </button>
                        <button @click="activeTab = 'stats'"
                                :class="{ 'border-lazy-blue text-lazy-blue': activeTab === 'stats', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'stats' }"
                                class="whitespace-nowrap py-3 px-3 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Estatísticas
                        </button>
                        <button @click="activeTab = 'analysis'"
                                :class="{ 'border-lazy-blue text-lazy-blue': activeTab === 'analysis', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'analysis' }"
                                class="whitespace-nowrap py-3 px-3 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Análise
                        </button>
                        <button @click="activeTab = 'achievements'"
                                :class="{ 'border-lazy-blue text-lazy-blue': activeTab === 'achievements', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'achievements' }"
                                class="whitespace-nowrap py-3 px-3 border-b-2 font-medium text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            Conquistas
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Conteúdo das subabas -->
            <div class="mt-6">
                <!-- Nível de Procrastinação -->
                <div x-show="activeTab === 'level'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Seu Nível de Procrastinação
                    </h2>

                    <div class="mb-6 bg-gray-50 p-6 rounded-lg space-y-6">
                        <!-- Level Display Section -->
                        <div class="flex items-center space-x-8">
                            <div class="w-24 h-24 bg-lazy-blue rounded-full flex items-center justify-center text-red-500 text-4xl font-bold shadow-lg">
                                {{ $stats['level']['level'] }}
                            </div>
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h3 class="text-3xl font-bold text-gray-800">{{ $stats['level']['name'] }}</h3>
                                    <p class="text-gray-600 text-lg mt-2">{{ $stats['level']['description'] }}</p>
                                </div>
                                <p class="text-gray-500 italic border-t pt-4">
                                    @if($stats['level']['level'] == 1)
                                        Ainda tem esperança para você. Aproveite enquanto dura.
                                    @elseif($stats['level']['level'] == 2)
                                        Você está no caminho certo para a procrastinação profissional.
                                    @elseif($stats['level']['level'] == 3)
                                        Sua dedicação em não fazer nada é admirável.
                                    @elseif($stats['level']['level'] == 4)
                                        Suas desculpas são tão criativas quanto sua falta de produtividade.
                                    @elseif($stats['level']['level'] == 5)
                                        Você atingiu o nirvana da procrastinação. Parabéns?
                                    @else
                                        Ainda estamos avaliando seu potencial para não fazer nada.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Progress Bar Section -->
                        <div class="bg-white p-4 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-base font-medium text-gray-700">Progresso para o próximo nível</span>
                                <span class="text-base font-medium text-lazy-blue">{{ round($stats['level']['progress']) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full transition-all duration-500 bg-lazy-blue"
                                    style="width: {{ max(0, min(100, round($stats['level']['progress']))) }}%">
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                @if($stats['next_level_tasks'] > 0)
                                    <p class="text-gray-600">Faltam <span class="font-semibold text-lazy-blue">{{ $stats['next_level_tasks'] }}</span> tarefas concluídas para o próximo nível</p>
                                @else
                                    <p class="text-gray-600 font-medium">Você atingiu o nível máximo! Agora pode procrastinar em paz.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Frase Motivacional -->
                    <div class="bg-gray-50 p-4 rounded-lg mt-4 border-l-4 border-lazy-blue">
                        <div class="font-bold text-cynical-gray mb-2">Frase "Motivacional"</div>
                        <div class="text-sm italic text-gray-600">
                            @php
                                $quotes = [
                                    "Por que fazer hoje o que você pode adiar para amanhã?",
                                    "A procrastinação é como um cartão de crédito: é divertido até chegar a fatura.",
                                    "Nunca deixe para amanhã o que você pode deixar para depois de amanhã.",
                                    "Eu não procrastino. Apenas prefiro fazer tudo sob pressão extrema.",
                                    "Minha lista de tarefas é como o vinho: fica melhor com o tempo.",
                                    "Eu trabalho melhor sob pressão... é por isso que espero até o último minuto.",
                                    "Procrastinar é a arte de manter o passo com o ontem.",
                                    "Eu não estou procrastinando. Estou apenas priorizando o que não fazer primeiro."
                                ];
                                $randomQuote = $quotes[array_rand($quotes)];
                            @endphp
                            "{{ $randomQuote }}"
                        </div>
                    </div>
                </div>

                <!-- Estatísticas Detalhadas -->
                <div x-show="activeTab === 'stats'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Estatísticas Detalhadas
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-3xl font-bold text-gray-800">{{ $stats['completed'] }}</div>
                            <div class="text-sm text-gray-600">Tarefas Concluídas</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $stats['completion_rate'] }}% do total</div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-3xl font-bold text-gray-800">{{ $stats['pending'] }}</div>
                            <div class="text-sm text-gray-600">Tarefas Pendentes</div>
                            <div class="text-xs text-gray-500 mt-1">
                                @if($stats['overdue'] > 0)
                                    <span class="text-sarcastic-red">{{ $stats['overdue'] }} atrasadas</span>
                                @else
                                    Nenhuma atrasada (ainda)
                                @endif
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-3xl font-bold text-gray-800">{{ $stats['failed'] }}</div>
                            <div class="text-sm text-gray-600">Tarefas Falhas</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $stats['failure_rate'] }}% do total</div>
                        </div>
                    </div>
                </div>

                <!-- Análise Sarcástica -->
                <div x-show="activeTab === 'analysis'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Análise Sarcástica
                    </h2>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700">
                            @if($stats['completion_rate'] < 20)
                                Sua taxa de conclusão é impressionantemente baixa. Você é um verdadeiro mestre da procrastinação ou só está colecionando tarefas?
                            @elseif($stats['completion_rate'] < 50)
                                Menos da metade das tarefas concluídas? Pelo menos você é honesto sobre suas limitações.
                            @elseif($stats['completion_rate'] < 80)
                                Uma taxa de conclusão decente. Você está no limbo entre ser produtivo e procrastinador.
                            @else
                                Uau, mais de 80% concluído! Você está usando o app errado. Deveria estar no "Faça Tudo".
                            @endif
                        </p>
                        <p class="text-gray-700 mt-2">
                            @if($stats['failure_rate'] > 30)
                                Sua taxa de falha é impressionante. Pelo menos você é honesto sobre suas limitações!
                            @elseif($stats['failure_rate'] > 10)
                                Algumas falhas são esperadas. Afinal, você está usando um app chamado "Não Faça".
                            @else
                                Taxa de falha baixa? Ou você é muito bom ou muito covarde para admitir quando desiste.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Conquistas -->
                <div x-show="activeTab === 'achievements'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h2 class="text-xl font-semibold mb-4 text-cynical-gray flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        Suas Conquistas
                    </h2>

                    <div class="space-y-3">
                        @if(count($stats['achievements']) > 0)
                            @foreach($stats['achievements'] as $achievement)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="text-2xl mr-3">{{ $achievement['icon'] }}</div>
                                    <div>
                                        <div class="font-medium">{{ $achievement['name'] }}</div>
                                        <div class="text-sm text-gray-600">{{ $achievement['description'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-4 bg-gray-50 rounded-lg text-center">
                                <p class="text-gray-600 italic">Nenhuma conquista ainda. Continue procrastinando de forma produtiva!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
