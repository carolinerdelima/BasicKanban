<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Models\Column;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function __construct(private TaskService $service) {}

    /**
     * Lista todas as tasks visíveis para o usuário (em boards onde ele é membro)
     */
    public function index(Request $request)
    {
        return $this->service->getTasksVisibleForUser($request->user());
    }

    /**
     * Cria uma nova task (somente se o usuário for membro do board da coluna)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'column_id' => 'required|exists:columns,id',
            'user_id' => 'nullable|exists:users,id',
            'position' => 'nullable|integer',
        ]);

        $task = $this->service->createTask($request->user(), $validated);

        return response()->json($task, 201);
    }

    /**
     * Atualiza uma task (somente se o usuário for membro do board da coluna atual da task)
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'column_id' => 'sometimes|exists:columns,id',
            'user_id' => 'nullable|exists:users,id',
            'position' => 'nullable|integer',
        ]);

        $this->service->updateTask($task, $request->user(), $validated);

        return response()->json($task);
    }

    /**
     * Exclui uma task (somente se o usuário for membro do board da coluna da task)
     */
    public function destroy(Request $request, Task $task)
    {
        $this->service->deleteTask($task, $request->user());

        return response()->json(['message' => 'Tarefa excluída com sucesso']);
    }

    /**
     * Move uma task de coluna
     */
    public function move(Request $request, Task $task)
    {
        $validated = $request->validate([
            'column_id' => 'required|exists:columns,id',
            'position'  => 'required|integer|min:1',
        ]);

        $this->service->moveTask(
            $task,
            Column::findOrFail($validated['column_id']),
            $validated['position'],
            $request->user()
        );

        return response()->json(['message' => 'Task movida com sucesso']);
    }
}
