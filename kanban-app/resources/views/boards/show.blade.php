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
                    class="user-icon me-2"
                    alt="User Icon">
            <span id="loggedUserName" class="fw-bold text-white"></span>
        </div>
    </div>

    <meta name="board-id" content="{{ $boardId }}">

    <div class="page-title text-center mb-3">
        <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
        Kanban App - Board #{{ $boardId }}
    </div>

    <div class="text-center mb-4">
        <button id="createTaskButton" class="primary-action-button">
            <i class="fas fa-plus-circle"></i> Criar Nova Task
        </button>
    </div>

    <div id="taskModalOverlay" style="display:none;">
        <div id="taskModalContent">
            <h4 class="mb-3">Criação de Task</h4>

            <input  id="taskTitle"
                    type="text"
                    class="form-control mb-2"
                    placeholder="Título da task">

            <textarea id="taskDescription"
                        class="form-control mb-3"
                        placeholder="Descrição (opcional)"
                        rows="3"></textarea>

            <button id="saveTask"      class="btn btn-primary w-100 mb-2">Salvar</button>
            <button id="closeTaskModal" class="btn btn-secondary w-100">Cancelar</button>
        </div>
    </div>

    <div id="kanbanBoard" class="kanban-board"></div>
@endsection