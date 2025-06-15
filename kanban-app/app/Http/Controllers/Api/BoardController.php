<?php

namespace App\Http\Controllers\Api;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Services\BoardService;
use App\Http\Controllers\Controller;

class BoardController extends Controller
{
    public function __construct(private BoardService $service) {}

    /**
     * Lista todos os boards onde o usuário é membro
     */
    public function index(Request $request)
    {
        return $this->service->getBoardsForUser($request->user());
    }

    /**
     * Cria um novo board e adiciona o usuário como membro automaticamente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = $this->service->createBoard($request->user(), $validated);

        return response()->json($board, 201);
    }

    /**
     * Mostra detalhes de um board (se o usuário for membro)
     */
    public function show(Request $request, Board $board)
    {
        $board = $this->service->showBoard($request->user(), $board);

        return response()->json($board);
    }
}
