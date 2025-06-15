<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    /**
     * Realiza o login do usuário
     * Recebe email e senha, valida, autentica e gera um token do Sanctum
     */
    public function login(Request $request)
    {
        // Validação dos campos obrigatórios
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Faz login e retorna token
        $token = $this->service->login($data['email'], $data['password']);

        return response()->json(['token' => $token]);
    }

    /**
     * Retorna os dados do usuário autenticado (baseado no token enviado)
     */
    public function user(Request $request)
    {
        $user = $this->service->getUser($request);

        return response()->json($user);
    }

    /**
     * Faz o logout, deletando todos os tokens ativos do usuário
     */
    public function logout(Request $request)
    {
        $this->service->logout($request);

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
