<?php

namespace App\Http\Controllers\Api;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Services\ColumnService;
use App\Http\Controllers\Controller;

class ColumnController extends Controller
{
    public function __construct(private ColumnService $service) {}

    /**
     * Retorna todas as colunas de um board específico,
     * junto com as tasks de cada coluna e os usuários responsáveis por cada task
     *
     * @param Board $board  O board que queremos listar as colunas
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Board $board)
    {
        $columns = $this->service->getColumnsForBoard($board, $request->user());

        return response()->json($columns);
    }
}
