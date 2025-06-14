<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'column_id', 'user_id', 'position'];

    /**
     * Uma Task pertence a uma Column
     */
    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    /**
     * Uma Task pertence a um User (responsável pela tarefa)
     * Pode ser nulo se a tarefa ainda não tiver responsável
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
