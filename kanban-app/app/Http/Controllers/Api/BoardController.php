<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Lista todos os boards onde o usuário é membro
     */
    public function index(Request $request)
    {
        return $request->user()->boards()->get();
    }

    /**
     * Cria um novo board e adicionar o usuário como membro automaticamente
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board = Board::create([
            'name' => $request->name,
            'user_id' => $request->user()->id, // Usuário que criou (dono)
        ]);

        // Adiciona o criador como membro automaticamente
        $board->users()->attach($request->user()->id);

        return response()->json($board, 201);
    }

    /**
     * Mostra detalhes de um board (se o usuário for membro)
     */
    public function show(Request $request, Board $board)
    {
        // Verifica se o usuário é membro do board
        if (!$request->user()->boards()->where('boards.id', $board->id)->exists()) {
            return response()->json(['message' => 'Acesso negado ao board.'], 403);
        }

        return response()->json($board);
    }
}
