<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Column;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Lista todas as tasks visíveis para o usuário (em boards onde ele é membro)
     */
    public function index(Request $request)
    {
        $userBoardIds = $request->user()->boards()->pluck('boards.id');

        return Task::whereHas('column.board', function ($query) use ($userBoardIds) {
            $query->whereIn('boards.id', $userBoardIds);
        })->with(['user', 'column'])->get();
    }

    /**
     * Cria uma nova task (somente se o usuário for membro do board da coluna)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'column_id' => 'required|exists:columns,id',
            'user_id' => 'nullable|exists:users,id',
            'position' => 'nullable|integer',
        ]);

        $column = Column::findOrFail($request->column_id);
        $user = $request->user();

        // Verifica se o usuário é membro do board da coluna
        if (!$user->boards()->where('boards.id', $column->board_id)->exists()) {
            return response()->json(['message' => 'Acesso negado: você não faz parte deste board.'], 403);
        }

        $task = Task::create($request->only(['title', 'description', 'column_id', 'user_id', 'position']));

        return response()->json($task, 201);
    }

    /**
     * Atualiza uma task (somente se o usuário for membro do board da coluna atual da task)
     */
    public function update(Request $request, Task $task)
    {
        $user = $request->user();

        if (!$user->boards()->where('boards.id', $task->column->board_id)->exists()) {
            return response()->json(['message' => 'Acesso negado: você não faz parte deste board.'], 403);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'column_id' => 'sometimes|exists:columns,id',
            'user_id' => 'nullable|exists:users,id',
            'position' => 'nullable|integer',
        ]);

        $task->update($request->only(['title', 'description', 'column_id', 'user_id', 'position']));

        return response()->json($task);
    }

    /**
     * Exclui uma task (somente se o usuário for membro do board da coluna da task)
     */
    public function destroy(Request $request, Task $task)
    {
        $user = $request->user();

        if (!$user->boards()->where('boards.id', $task->column->board_id)->exists()) {
            return response()->json(['message' => 'Acesso negado: você não faz parte deste board.'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa excluída com sucesso']);
    }
}
