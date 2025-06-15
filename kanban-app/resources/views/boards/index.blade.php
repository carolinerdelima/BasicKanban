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

<div class="page-title">
    <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
    Kanban App
</div>

<h2 class="boards-title">Meus Boards</h2>

<div id="boardsList" class="boards-container"></div>

<button id="createBoardButton" class="btn btn-outline-light d-block mx-auto mb-3">
    <span style="font-weight:bold; margin-right: 5px;">+</span> Criar Novo Board
</button>

<div id="boardModalOverlay" style="display:none;">
    <div id="boardModalContent">
        <h4>Criar Novo Board</h4>
        <input type="text" id="newBoardName" placeholder="Nome do board">
        <button id="saveBoard" class="btn btn-primary w-100 mt-2">Salvar</button>
        <button id="closeBoardModal" class="btn btn-secondary w-100 mt-2">Cancelar</button>
    </div>
</div>

@endsection
