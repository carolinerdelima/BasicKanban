<?php

namespace App\Repositories;

use App\Models\Board;
use App\Models\User;

class BoardRepository
{
    /**
     * Retorna todos os boards onde o usuário é membro
     */
    public function getBoardsForUser(User $user)
    {
        return $user->boards()->get();
    }

    /**
     * Cria um novo board
     */
    public function createBoard(array $data): Board
    {
        return Board::create($data);
    }

    /**
     * Adiciona um usuário como membro do board
     */
    public function attachUser(Board $board, User $user): void
    {
        $board->users()->attach($user->id);
    }

    /**
     * Verifica se o usuário é membro de um board
     */
    public function userHasAccess(User $user, Board $board): bool
    {
        return $user->boards()->where('boards.id', $board->id)->exists();
    }
}
