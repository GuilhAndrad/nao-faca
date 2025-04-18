<?php

namespace App\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TaskManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $activeTab = 'pending';
    public $tasks = [];

    // Task form properties
    public $newTaskName = '';
    public $newTaskPriority = 2;
    public $newTaskDueDate = null;

    // Task editing properties
    public $editingTaskId = null;
    public $editingTaskName = '';
    public $editingTaskPriority = 1;
    public $editingTaskDueDate = null;

    // Make sure to listen for these events
    // Change the listeners to use the new Livewire 3 syntax
    protected $listeners = ['refresh' => '$refresh'];

    // Remove the echo listener that might be causing issues
    // protected $listeners = ['taskAdded', 'taskUpdated', 'taskDeleted', 'echo:tasks,TaskUpdated' => 'refreshTasks'];

    public function mount()
    {
        // We'll load tasks in render method with pagination
        if (!auth()->check()) {
            $this->tasks = collect();
        }
    }

    public function loadTasks()
    {
        // This method will be used for non-paginated operations
        if (Auth::check()) {
            $this->tasks = Task::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        } else {
            $this->tasks = collect([]);
        }
    }

    public function refreshTasks()
    {
        $this->loadTasks();
    }

    public function render()
    {
        // Only proceed if user is authenticated
        if (!Auth::check()) {
            return view('livewire.task-manager', [
                'tasks' => collect(),
                'stats' => $this->getProcrastinationStats(),
            ]);
        }

        // For statistics, we need all tasks
        if (empty($this->tasks)) {
            $this->loadTasks();
        }

        // Get paginated tasks for each category
        $pendingTasks = auth()->user()->tasks()
            ->where('is_completed', false)
            ->where('is_failed', false)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'pending_page');

        $completedTasks = auth()->user()->tasks()
            ->where('is_completed', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'completed_page');

        $failedTasks = auth()->user()->tasks()
            ->where('is_failed', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'failed_page');

        // Calculate statistics
        $stats = $this->getProcrastinationStats();

        return view('livewire.task-manager', [
            'pendingTasks' => $pendingTasks,
            'completedTasks' => $completedTasks,
            'failedTasks' => $failedTasks,
            'stats' => $stats,
        ]);
    }

    // Add this method to reset pagination when changing tabs
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Reset to first page when changing tabs

        // Força uma atualização dos dados ao mudar de aba
        $this->loadTasks();
    }

    public function addTask()
    {
        if (!Auth::check()) {
            session()->flash('message', 'Você precisa estar logado para adicionar tarefas.');
            return;
        }

        $this->validate([
            'newTaskName' => 'required|min:3',
        ]);

        Auth::user()->tasks()->create([
            'name' => $this->newTaskName,
            'priority' => $this->newTaskPriority,
            'due_date' => $this->newTaskDueDate,
            'is_completed' => false,
            'is_failed' => false,
        ]);

        $this->reset(['newTaskName', 'newTaskPriority', 'newTaskDueDate']);
        $this->loadTasks();

        // Change to pending tab after adding a task
        $this->activeTab = 'pending';

        session()->flash('message', $this->getRandomSnarkyComment('add'));

        // Emit event for real-time updates
        $this->dispatch('taskAdded');
    }

    public function toggleComplete($taskId)
    {
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== Auth::id()) {
            return;
        }

        $task->is_completed = !$task->is_completed;
        $task->is_failed = false; // Reset failed status if it was failed
        $task->save();

        // Load tasks first before setting flash message
        $this->loadTasks();

        // Use message type for better styling
        if ($task->is_completed) {
            // Check time of day for more contextual messages
            $hour = now()->hour;
            if ($hour < 10) {
                session()->flash('message_type', 'complete_first');
                session()->flash('message', $this->getRandomSnarkyComment('complete_first'));
            } elseif ($hour >= 19) {
                session()->flash('message_type', 'complete_evening');
                session()->flash('message', $this->getRandomSnarkyComment('complete_evening'));
            } else {
                session()->flash('message_type', 'complete');
                session()->flash('message', $this->getRandomSnarkyComment('complete'));
            }
        } else {
            session()->flash('message_type', 'uncomplete');
            session()->flash('message', $this->getRandomSnarkyComment('uncomplete'));
        }

        // Use simpler event dispatch
        $this->dispatch('refresh');
    }

    public function markAsFailed($taskId)
    {
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== Auth::id()) {
            return;
        }

        $task->is_failed = true;
        $task->is_completed = false;
        $task->save();

        $this->loadTasks();

        session()->flash('message_type', 'fail');
        session()->flash('message', $this->getRandomSnarkyComment('fail'));

        // Use simpler event dispatch
        $this->dispatch('refresh');
    }

    public function restoreTask($taskId)
    {
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== Auth::id()) {
            return;
        }

        $task->is_failed = false;
        $task->is_completed = false;
        $task->save();

        $this->loadTasks();

        session()->flash('message_type', 'restore');
        session()->flash('message', $this->getRandomSnarkyComment('restore'));

        // Use simpler event dispatch
        $this->dispatch('refresh');
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskName' => 'required|min:3',
        ]);

        $task = Task::find($this->editingTaskId);

        if (!$task || $task->user_id !== Auth::id()) {
            return;
        }

        $task->update([
            'name' => $this->editingTaskName,
            'due_date' => $this->editingTaskDueDate ? Carbon::parse($this->editingTaskDueDate) : null,
            'priority' => $this->editingTaskPriority,
        ]);

        $this->editingTaskId = null;
        $this->loadTasks();

        session()->flash('message_type', 'update');
        session()->flash('message', $this->getRandomSnarkyComment('update'));

        // Emit event for real-time updates
        $this->dispatch('taskUpdated');
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== Auth::id()) {
            return;
        }

        $task->delete();
        $this->loadTasks();

        session()->flash('message_type', 'delete');
        session()->flash('message', $this->getRandomSnarkyComment('delete'));

        // Emit event for real-time updates
        $this->dispatch('taskDeleted');
    }

    /**
     * Obtém dados detalhados de tarefas por dia da semana atual
     * Retorna um array com tarefas concluídas e falhas para cada dia
     */
    public function getWeeklyTasksData()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        // Inicializa array para cada dia da semana (0 = segunda, 6 = domingo)
        $weeklyData = [];
        for ($i = 0; $i < 7; $i++) {
            $weeklyData[$i] = [
                'completed' => [],
                'failed' => []
            ];
        }

        // Busca tarefas concluídas nesta semana
        $completedTasks = Task::where('user_id', auth()->id())
            ->where('is_completed', true)
            ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->get();

        // Agrupa por dia da semana
        foreach ($completedTasks as $task) {
            $dayOfWeek = $task->updated_at->dayOfWeek - 1; // Ajusta para 0-6 (seg-dom)
            if ($dayOfWeek < 0) $dayOfWeek = 6; // Ajusta domingo
            $weeklyData[$dayOfWeek]['completed'][] = $task;
        }

        // Busca tarefas que falharam nesta semana
        $failedTasks = Task::where('user_id', auth()->id())
            ->where('is_failed', true)
            ->whereBetween('updated_at', [$startOfWeek, $endOfWeek])
            ->get();

        // Agrupa por dia da semana
        foreach ($failedTasks as $task) {
            $dayOfWeek = $task->updated_at->dayOfWeek - 1; // Ajusta para 0-6 (seg-dom)
            if ($dayOfWeek < 0) $dayOfWeek = 6; // Ajusta domingo
            $weeklyData[$dayOfWeek]['failed'][] = $task;
        }

        return $weeklyData;
    }

    public function cancelEditing()
    {
        $this->editingTaskId = null;
    }

    public function getRandomSnarkyComment($type)
    {
        $comments = [
            'add' => [
                "Anotado. Mas você já vai procrastinar, não é?",
                "Mais uma pra lista do 'um dia eu faço'.",
                "Já pode atualizar o LinkedIn como 'Especialista em Listas'.",
                "Uau, mais uma tarefa. Sua produtividade é inversamente proporcional à sua lista.",
                "Adicionado à sua coleção de 'coisas que finjo que vou fazer'.",
                "Nova tarefa adicionada. Vamos ver quanto tempo você leva para ignorá-la.",
                "Tarefa adicionada à sua lista de 'talvez um dia'.",
                "Mais uma tarefa para sua coleção. Ambição não te falta, só motivação mesmo.",
                "Nova tarefa criada. Suas intenções são boas, sua execução... bem, veremos.",
                "Tarefa adicionada. Seu eu futuro agradece (e provavelmente te odeia um pouco)."
            ],
            'complete' => [
                "Marcou como concluído... Será que não foi engano?",
                "Parabéns! Você fez o mínimo esperado.",
                "Uma tarefa concluída. Agora só faltam... todas as outras.",
                "Uau, você realmente fez algo hoje. Impressionante.",
                "Parabéns! Você concluiu uma tarefa. Quem diria que isso era possível?",
                "Uau, você realmente fez algo hoje. Marque no calendário.",
                "Tarefa concluída. Agora você pode voltar a procrastinar com a consciência limpa.",
                "Incrível! Você concluiu uma tarefa. Quer uma medalha ou algo assim?",
                "Tarefa concluída. Sua produtividade surpreendente está arruinando a reputação deste app."
            ],
            'complete_first' => [
                "Uau. Alguém acordou ambicioso hoje.",
                "Primeira tarefa do dia? Deve ser um erro no sistema.",
                "Começando o dia produtivo? Quem é você e o que fez com o usuário real?",
                "Produtividade logo cedo? Isso é suspeito.",
                "Primeira tarefa do dia concluída. O resto do dia é para procrastinar, certo?"
            ],
            'complete_evening' => [
                "Trabalho noturno? Alguém está desesperado.",
                "Concluindo tarefas à noite? O desespero bateu, né?",
                "Produtividade noturna: quando o pânico vence o sono.",
                "Fazendo tarefas tarde da noite? O prazo é amanhã, não é?",
                "Produtividade noturna. Nada como o pânico do último minuto para motivar."
            ],
            'uncomplete' => [
                "Desmarcar como concluída? Ah, a honestidade tardia...",
                "Voltando atrás? Pelo menos é sincero com seu fracasso.",
                "Ops, marcou por engano? Ou é só a realidade te atingindo?",
                "Desmarcando tarefas? Indecisão é o primeiro sintoma da procrastinação crônica.",
                "Tarefa desmarcada. Sua honestidade é admirável, sua produtividade nem tanto."
            ],
            'update' => [
                "Editando tarefas em vez de concluí-las. Clássico.",
                "Mudar a tarefa não vai torná-la mais fácil, sabe?",
                "Ah, a ilusão de que renomear a tarefa vai ajudar a concluí-la.",
                "Tarefa editada. Mudando as regras no meio do jogo, clássico procrastinador.",
                "Tarefa atualizada. Reescrever é mais fácil que realizar, não é?",
                "Você alterou a tarefa. Provavelmente para torná-la ainda mais impossível.",
                "Tarefa modificada. Ajustando expectativas para evitar decepções futuras?",
                "Tarefa editada. Pelo menos você está mantendo suas procrastinações organizadas."
            ],
            'delete' => [
                "Parabéns! Você eliminou 1 tarefa... e criou 0 substitutas. Progresso?",
                "Deletar é mais fácil que concluir, não é?",
                "Tarefa excluída. Fingir que nunca existiu é uma estratégia interessante.",
                "Tarefa deletada. A forma mais eficiente de completar algo é fingir que nunca existiu.",
                "Tarefa eliminada. Tecnicamente não é procrastinação se a tarefa não existe mais.",
                "Poof! A tarefa desapareceu. Magia ou fuga da responsabilidade? Você decide.",
                "Tarefa removida da sua lista. Estratégia ousada, mas eficaz."
            ],
            'fail' => [
                "Oficialmente um fracasso. Pelo menos você é honesto.",
                "Adicionado ao seu mural da derrota. Parabéns?",
                "Mais um para a coleção de 'tentei, mas nem tanto'.",
                "Falhou? Que surpresa... disse ninguém, nunca.",
                "Pelo menos você é bom em desistir. Isso é um talento também.",
                "Tarefa falhou. Pelo menos você é honesto sobre suas limitações.",
                "Mais uma para a lista de 'coisas que eu nunca vou fazer'. Impressionante coleção!",
                "Falhou em uma tarefa? Bem-vindo ao clube dos realistas.",
                "Tarefa marcada como falha. Sua sinceridade é admirável.",
                "Você não fez isso. Nós sabíamos, você sabia, todo mundo sabia."
            ],
            'restore' => [
                "Restaurando uma tarefa? Otimismo renovado ou apenas adiando o inevitável?",
                "Tarefa restaurada. Segunda chance para procrastinar novamente.",
                "Tarefa de volta à lista. Persistência ou masoquismo? Você decide.",
                "Restaurada! Mais uma oportunidade para falhar de forma diferente.",
                "Tarefa restaurada. Esperança é a última que morre, não é mesmo?"
            ],
        ];

        $selectedType = $comments[$type] ?? $comments['add'];
        return $selectedType[array_rand($selectedType)];
    }

    public function getProgressMessage()
    {
        $completedCount = $this->tasks->where('is_completed', true)->count();
        $totalCount = $this->tasks->count();

        if ($totalCount === 0) {
            return "Sem tarefas? Que vida tranquila você leva... ou será que está evitando responsabilidades?";
        }

        $percentage = ($completedCount / $totalCount) * 100;

        if ($percentage === 0) {
            return "0% concluído. Pelo menos você é consistente na procrastinação.";
        } elseif ($percentage < 25) {
            return "Menos de 25%? Você está realmente se esforçando... para evitar suas responsabilidades.";
        } elseif ($percentage < 50) {
            return "Quase na metade! Continue assim e talvez termine antes do próximo século.";
        } elseif ($percentage < 75) {
            return "Mais da metade! Surpreendentemente produtivo para alguém que usa um app chamado 'Não Faça'.";
        } elseif ($percentage < 100) {
            return "Quase lá! Só faltam algumas tarefas para você poder procrastinar em paz.";
        } else {
            return "100% concluído? Você deve ter hackeado o sistema ou realmente é um unicórnio produtivo.";
        }
    }

    public function calculateProcrastinationLevel()
    {
        $total = count($this->tasks);
        if ($total == 0) return "Novato";

        $failed = $this->tasks->where('is_failed', true)->count();
        $overdue = $this->tasks->where('is_completed', false)
                            ->where('is_failed', false)
                            ->filter(function($task) {
                                return $task->is_overdue;
                            })->count();

        $procrastinationScore = ($failed * 2 + $overdue) / $total;

        if ($procrastinationScore < 0.2) return "Iniciante Promissor";
        if ($procrastinationScore < 0.4) return "Procrastinador Casual";
        if ($procrastinationScore < 0.6) return "Procrastinador Dedicado";
        if ($procrastinationScore < 0.8) return "Mestre da Desculpa";
        return "Lendário Adiador Profissional";
    }

    // Método para obter estatísticas de procrastinação
    public function getProcrastinationStats()
    {
        $user = auth()->user();
        $completedTasks = $this->tasks->where('is_completed', true)->count();
        $failedTasks = $this->tasks->where('is_failed', true)->count();
        $pendingTasks = $this->tasks->where('is_completed', false)->where('is_failed', false)->count();
        $totalTasks = $this->tasks->count();
        $overdueTasks = $this->tasks->where('is_completed', false)->where('is_failed', false)
            ->filter(function($task) {
                return $task->due_date && $task->due_date->isPast();
            })->count();

        // Calculate level based on completed tasks
        $level = $this->calculateUserLevel($completedTasks);

        // Get achievements
        $achievements = $this->getUserAchievements($completedTasks, $failedTasks, $overdueTasks);

        return [
            'completed' => $completedTasks,
            'failed' => $failedTasks,
            'pending' => $pendingTasks,
            'total' => $totalTasks,
            'overdue' => $overdueTasks,
            'level' => $level,
            'next_level_tasks' => $this->tasksForNextLevel($completedTasks),
            'achievements' => $achievements,
            'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
            'failure_rate' => $totalTasks > 0 ? round(($failedTasks / $totalTasks) * 100) : 0,
        ];
    }

    private function calculateUserLevel($completedTasks)
    {
        // Level system: Each level requires progressively more tasks
        if ($completedTasks < 5) {
            return [
                'name' => 'Procrastinador Iniciante',
                'level' => 1,
                'description' => 'Você mal começou a evitar suas responsabilidades.',
                'progress' => min(100, ($completedTasks / 5) * 100)
            ];
        } elseif ($completedTasks < 15) {
            return [
                'name' => 'Procrastinador Casual',
                'level' => 2,
                'description' => 'Você está aprendendo a arte de adiar, mas ainda tem muito a melhorar.',
                'progress' => min(100, (($completedTasks - 5) / 10) * 100)
            ];
        } elseif ($completedTasks < 30) {
            return [
                'name' => 'Procrastinador Dedicado',
                'level' => 3,
                'description' => 'Você já domina as técnicas básicas de procrastinação produtiva.',
                'progress' => min(100, (($completedTasks - 15) / 15) * 100)
            ];
        } elseif ($completedTasks < 50) {
            return [
                'name' => 'Mestre Procrastinador',
                'level' => 4,
                'description' => 'Sua habilidade em completar tarefas no último segundo é impressionante.',
                'progress' => min(100, (($completedTasks - 30) / 20) * 100)
            ];
        } else {
            return [
                'name' => 'Lenda da Procrastinação',
                'level' => 5,
                'description' => 'Você transcendeu o tempo e o espaço. Completa tarefas enquanto procrastina.',
                'progress' => 100
            ];
        }
    }

    private function tasksForNextLevel($completedTasks)
    {
        if ($completedTasks < 5) {
            return 5 - $completedTasks;
        } elseif ($completedTasks < 15) {
            return 15 - $completedTasks;
        } elseif ($completedTasks < 30) {
            return 30 - $completedTasks;
        } elseif ($completedTasks < 50) {
            return 50 - $completedTasks;
        } else {
            return 0; // Max level reached
        }
    }

    private function getUserAchievements($completedTasks, $failedTasks, $overdueTasks)
    {
        $achievements = [];

        // Completion achievements
        if ($completedTasks >= 1) {
            $achievements[] = [
                'name' => 'Primeiro Passo',
                'description' => 'Completou sua primeira tarefa. Quem diria?',
                'icon' => '🏆'
            ];
        }

        if ($completedTasks >= 1) {
            $achievements[] = [
                'name' => 'Produtividade Suspeita',
                'description' => 'Completou 10 tarefas. Está realmente procrastinando?',
                'icon' => '🔥'
            ];
        }

        if ($completedTasks >= 1) {
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

        return $achievements;
    }
}
