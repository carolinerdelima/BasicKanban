@extends('layouts.app')

@section('content')

<div class="login-wrapper">
    <div class="page-title">
        <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
        Kanban App
    </div>

    <div class="login-card">
        <h2>Login</h2>

        <form id="loginForm">
            <div class="mb-3 text-start">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Digite seu email">
            </div>

            <div class="mb-3 text-start">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" placeholder="Digite sua senha">
            </div>

            <button type="submit" class="btn w-100">Entrar</button>
        </form>
    </div>
</div>

@endsection
