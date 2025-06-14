<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Realiza o login do usuário
     * Recebe email e senha, valida, autentica e gera um token do Sanctum
     */
    public function login(Request $request)
    {
        // Validação dos campos obrigatórios
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Busca o usuário pelo email
        $user = User::where('email', $request->email)->first();

        // Verifica se o usuário existe e se a senha está correta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Gera um token de API com Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // Retorna o token para o frontend (para usar em requisições futuras)
        return response()->json(['token' => $token]);
    }

    /**
     * Retorna os dados do usuário autenticado (baseado no token enviado)
     */
    public function user(Request $request)
    {
        // Retorna os dados do usuário logado
        return response()->json($request->user());
    }

    /**
     * Faz o logout, deletando todos os tokens ativos do usuário
     */
    public function logout(Request $request)
    {
        // Exclui todos os tokens do usuário autenticado
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
