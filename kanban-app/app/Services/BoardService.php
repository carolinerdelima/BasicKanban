<?php

namespace App\Services;

use App\Models\Board;
use App\Models\User;
use App\Repositories\BoardRepository;

class BoardService
{
    public function __construct(private BoardRepository $repo) {}

    /**
     * Retorna boards visíveis para o usuário
     */
    public function getBoardsForUser(User $user)
    {
        return $this->repo->getBoardsForUser($user);
    }

    /**
     * Cria um board e já adiciona o criador como membro
     */
    public function createBoard(User $user, array $data): Board
    {
        $board = $this->repo->createBoard([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);

        $this->repo->attachUser($board, $user);

        return $board;
    }

    /**
     * Retorna detalhes do board, validando se o usuário tem acesso
     */
    public function showBoard(User $user, Board $board): Board
    {
        if (! $this->repo->userHasAccess($user, $board)) {
            abort(403, 'Acesso negado ao board.');
        }

        return $board;
    }
}
