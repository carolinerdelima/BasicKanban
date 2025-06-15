<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Column;
use App\Models\User;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $repo) {}

    /**
     * Retorna as tasks visíveis para o usuário (em boards onde ele é membro)
     */
    public function getTasksVisibleForUser(User $user)
    {
        $boardIds = $user->boards()->pluck('boards.id')->toArray();
        return $this->repo->getTasksForBoards($boardIds);
    }

    /**
     * Cria uma task, validando se o usuário pode criar na coluna desejada
     */
    public function createTask(User $user, array $data): Task
    {
        $column = Column::findOrFail($data['column_id']);

        $this->authorizeUserForBoard($user, $column->board_id);

        return $this->repo->create($data);
    }

    /**
     * Atualiza uma task, validando acesso
     */
    public function updateTask(Task $task, User $user, array $data): Task
    {
        $this->authorizeUserForBoard($user, $task->column->board_id);

        return $this->repo->update($task, $data);
    }

    /**
     * Exclui uma task, validando acesso
     */
    public function deleteTask(Task $task, User $user): void
    {
        $this->authorizeUserForBoard($user, $task->column->board_id);

        $this->repo->delete($task);
    }

    /**
     * Move uma task para outra coluna e/ou posição
     */
    public function moveTask(Task $task, Column $toColumn, int $newPosition, User $user): void
    {
        $this->authorizeUserForBoard($user, $task->column->board_id);
        $this->authorizeUserForBoard($user, $toColumn->board_id);

        // Se a task estiver em Done, só pode ficar lá
        $doneColumnName = 'Done';
        $fromColumn = $task->column;

        if (strtolower($fromColumn->name) === strtolower($doneColumnName) && $toColumn->id !== $fromColumn->id) {
            abort(403, 'Não é permitido mover tasks de Done para colunas anteriores.');
        }

        $this->repo->move($task, $toColumn, $newPosition);
    }

    /**
     * Verifica se o usuário tem acesso ao board
     */
    private function authorizeUserForBoard(User $user, int $boardId): void
    {
        if (!$user->boards()->where('boards.id', $boardId)->exists()) {
            abort(403, 'Acesso negado: você não faz parte deste board.');
        }
    }
}
