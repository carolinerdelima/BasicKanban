<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    /**
     * Busca um usuário pelo e-mail
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Verifica se a senha informada é válida
     */
    public function validatePassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Gera um token Sanctum para o usuário
     */
    public function createToken(User $user): string
    {
        return $user->createToken('api-token')->plainTextToken;
    }

    /**
     * Exclui todos os tokens ativos do usuário
     */
    public function revokeTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
