<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\Column;
use Illuminate\Support\Facades\DB;

class TaskRepository
{
    /**
     * Retorna todas as tasks de boards que o usuário tem acesso
     */
    public function getTasksForBoards(array $boardIds)
    {
        return Task::whereHas('column.board', function ($query) use ($boardIds) {
                $query->whereIn('boards.id', $boardIds);
            })
            ->with(['user', 'column'])
            ->get();
    }

    /**
     * Cria uma nova task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Atualiza uma task existente
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    /**
     * Exclui uma task
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }

    /**
     * Move uma task entre colunas e ajusta as posições
     */
    public function move(Task $task, Column $toColumn, int $newPosition): void
    {
        DB::transaction(function () use ($task, $toColumn, $newPosition) {

            // Reorganiza a coluna de origem
            $task->column
                ->tasks()
                ->where('position', '>', $task->position)
                ->decrement('position');

            // Reorganiza a coluna de destino
            $toColumn
                ->tasks()
                ->where('position', '>=', $newPosition)
                ->increment('position');

            // Atualiza a task
            $task->update([
                'column_id' => $toColumn->id,
                'position'  => $newPosition,
            ]);
        });
    }
}
