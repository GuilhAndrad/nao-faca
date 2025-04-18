<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'due_date',
        'is_completed',
        'is_failed',
        'user_id', // Adicionado campo user_id
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
        'is_failed' => 'boolean',
    ];

    // Relacionamento com o usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Getter para verificar se a tarefa está atrasada
    public function getIsOverdueAttribute()
    {
        if (!$this->due_date) {
            return false;
        }

        return !$this->is_completed && !$this->is_failed && $this->due_date->isPast();
    }
}
