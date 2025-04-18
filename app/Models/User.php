<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento com as tarefas do usuário
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Calcula o nível de procrastinação do usuário
     */
    public function getProcrastinationLevel()
    {
        $tasks = $this->tasks;
        $totalTasks = $tasks->count();

        if ($totalTasks === 0) {
            return 'Novato na Procrastinação';
        }

        $failedTasks = $tasks->where('is_failed', true)->count();
        $overdueTasks = $tasks->filter(function ($task) {
            return $task->is_overdue;
        })->count();

        $procrastinationScore = ($failedTasks + $overdueTasks) / $totalTasks;

        if ($procrastinationScore >= 0.7) {
            return 'Mestre da Procrastinação';
        } elseif ($procrastinationScore >= 0.4) {
            return 'Procrastinador Profissional';
        } elseif ($procrastinationScore >= 0.2) {
            return 'Procrastinador Casual';
        } else {
            return 'Produtivo Demais (Suspeito)';
        }
    }
}
