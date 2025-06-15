<?php

namespace App\Repositories;

use App\Models\Board;

class ColumnRepository
{
    /**
     * Retorna todas as colunas de um board,
     * incluindo as tasks e o usuário responsável de cada task
     */
    public function getColumnsWithTasksAndUsers(Board $board)
    {
        return $board->columns()
            ->with('tasks.user')
            ->orderBy('position')
            ->get();
    }
}
