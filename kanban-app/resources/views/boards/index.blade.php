@extends('layouts.app')

@section('content')

<div class="page-title">
    <img src="{{ asset('images/kanban-icon.png') }}" alt="Kanban Icon">
    Kanban App
</div>

<h2 class="boards-title">Meus Boards</h2>

<div id="boardsList" class="boards-container"></div>

@endsection
