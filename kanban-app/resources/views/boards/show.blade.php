@extends('layouts.app')

@section('content')

<div class="top-bar d-flex justify-content-between align-items-center mb-3">
    <div>
        <button id="logoutButton" class="btn btn-sm btn-outline-light" title="Sair da conta">
            Logout
        </button>
    </div>

    <div class="user-info d-flex align-items-center">
        <img src="{{ asset('images/user-icon.png') }}" alt="User Icon" class="user-icon me-2">
        <span id="loggedUserName" class="fw-bold text-white"></span>
    </div>
</div>

<meta name="board-id" content="{{ $boardId }}">

<div class="page-title">
    <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
    Kanban App - Board #{{ $boardId }}
</div>

<div id="kanbanBoard" class="kanban-board"></div>

@endsection
