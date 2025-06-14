<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Retorna todas as colunas de um board específico,
     * junto com as tasks de cada coluna e os usuários responsáveis por cada task
     *
     * @param Board $board  O board que queremos listar as colunas
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Board $board)
    {
        // Verifica se o usuário tem permissão de acesso ao board
        if (!$request->user()->boards()->where('boards.id', $board->id)->exists()) {
            return response()->json(['message' => 'Acesso negado ao board.'], 403);
        }

        // Retorna as colunas do board, junto com:
        // * As tasks dentro de cada coluna
        // * O usuário responsável de cada task
        return $board->columns()
            ->with('tasks.user')        // Carrega as tasks e o usuário relacionado de cada task
            ->orderBy('position')       // Ordena as colunas pela posição (ordem visual no frontend)
            ->get();
    }
}
