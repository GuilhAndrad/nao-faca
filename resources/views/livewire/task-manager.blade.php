<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <x-sarcastic-flash :message="session('message')" :type="session('message_type')" />
    @endif

    @guest
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-xl font-semibold mb-4 text-cynical-gray">Você precisa estar logado</h2>
            <p class="text-gray-600 mb-6">Faça login ou registre-se para gerenciar suas tarefas que você provavelmente não vai fazer.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('login') }}" class="bg-lazy-blue hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-sarcastic-red hover:bg-red-600 text-white py-2 px-4 rounded">
                    Registrar
                </a>
            </div>
        </div>
    @else
        <!-- Progress bar - Now appears on all tabs -->
        <x-task-progress-bar :tasks="$tasks" :progress-message="$this->getProgressMessage()" />

        <!-- Abas de navegação -->
        <x-task-navigation :active-tab="$activeTab" :tasks="$tasks" />

        <!-- Conteúdo das abas -->
        <div>
            @if($activeTab === 'add')
                <x-task-add-form
                    :new-task-name="$newTaskName"
                    :new-task-priority="$newTaskPriority"
                    :new-task-due-date="$newTaskDueDate"
                />
            @endif

            @if($activeTab === 'pending')
                <x-task-pending-list
                    :pendingTasks="$pendingTasks"
                    :editingTaskId="$editingTaskId"
                    :editingTaskName="$editingTaskName"
                    :editingTaskPriority="$editingTaskPriority"
                    :editingTaskDueDate="$editingTaskDueDate" />
            @endif

            @if($activeTab === 'completed')
                <x-task-completed-list :completedTasks="$completedTasks" />
            @endif

            @if($activeTab === 'failed')
                <x-task-failed-list :failedTasks="$failedTasks" />
            @endif

            @if($activeTab === 'stats')
                <x-task-statistics :tasks="$tasks" :stats="$this->getProcrastinationStats()" />
            @endif
        </div>
    @endguest
</div>
