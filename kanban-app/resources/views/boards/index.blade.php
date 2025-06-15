@extends('layouts.app')

@section('content')
    <div class="top-bar d-flex justify-content-between align-items-center mb-3">
        <button id="logoutButton"
                class="btn btn-sm btn-outline-light"
                title="Sair da conta">
            Logout
        </button>

        <div class="user-info d-flex align-items-center">
            <img src="{{ asset('images/user-icon.png') }}"
                    alt="User Icon"
                    class="user-icon me-2">
            <span id="loggedUserName" class="fw-bold text-white"></span>
        </div>
    </div>

    <div class="page-title mb-4 text-center">
        <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
        Kanban App
    </div>

    <div class="main-content d-flex flex-column align-items-center">

        <h2 class="boards-title">Meus Boards</h2>

        <div class="boards-wrapper w-100">
            <div id="boardsList" class="boards-container"></div>
        </div>

        <button id="createBoardButton" class="create-board-button">
            <i class="fas fa-plus-circle"></i>
            Criar Novo Board
        </button>
    </div>

    <div id="boardModalOverlay" style="display: none;">
        <div id="boardModalContent">
            <h4 class="mb-3">Criação de Board</h4>

            <input id="newBoardName"
                    type="text"
                    class="form-control mb-2"
                    placeholder="Nome do Board">

            <button id="saveBoard"  class="btn btn-primary w-100 mb-2">Salvar</button>
            <button id="closeBoardModal" class="btn btn-secondary w-100">Cancelar</button>
        </div>
    </div>
@endsection
