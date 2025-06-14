@extends('layouts.app')

@section('content')

<meta name="board-id" content="{{ $boardId }}">

<div class="page-title">
    <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
    Kanban App - Board #{{ $boardId }}
</div>

<div id="kanbanBoard" class="kanban-board"></div>

@endsection
