<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(private AuthRepository $repo) {}

    /**
     * Faz login do usuário e retorna o token ou lança erro
     */
    public function login(string $email, string $password): string
    {
        $user = $this->repo->findByEmail($email);

        if (! $user || ! $this->repo->validatePassword($user, $password)) {
            abort(401, 'Credenciais inválidas');
        }

        return $this->repo->createToken($user);
    }

    /**
     * Retorna o usuário autenticado
     */
    public function getUser(Request $request): User
    {
        return $request->user();
    }

    /**
     * Realiza o logout, revogando os tokens
     */
    public function logout(Request $request): void
    {
        $this->repo->revokeTokens($request->user());
    }
}
