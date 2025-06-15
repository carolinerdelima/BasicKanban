<?php

namespace App\Services;

use App\Models\Board;
use App\Models\User;
use App\Repositories\ColumnRepository;

class ColumnService
{
    public function __construct(private ColumnRepository $repo) {}

    /**
     * Retorna as colunas de um board, validando se o usuário tem acesso
     */
    public function getColumnsForBoard(Board $board, User $user)
    {
        if (! $user->boards()->where('boards.id', $board->id)->exists()) {
            abort(403, 'Acesso negado ao board.');
        }

        return $this->repo->getColumnsWithTasksAndUsers($board);
    }
}
