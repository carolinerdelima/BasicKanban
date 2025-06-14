@extends('layouts.app')

@section('content')
<h2>Kanban - Board ID: {{ $boardId }}</h2>

<div class="row" id="kanbanBoard">
    <!-- As colunas serão carregadas aqui via AJAX -->
</div>

<script>
$(document).ready(function() {
    const boardId = {{ $boardId }};

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    });

    function loadBoard() {
        $.get(`/api/boards/${boardId}/columns`, function(columns) {
            $('#kanbanBoard').empty();

            columns.forEach(function(column) {
                let columnHtml = `
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                ${column.name}
                            </div>
                            <ul class="list-group list-group-flush" id="column-${column.id}">
                `;

                column.tasks.forEach(function(task) {
                    columnHtml += `
                        <li class="list-group-item">
                            <strong>${task.title}</strong><br>
                            ${task.description || ''}
                        </li>
                    `;
                });

                columnHtml += `
                            </ul>
                        </div>
                    </div>
                `;

                $('#kanbanBoard').append(columnHtml);
            });
        }).fail(function(xhr) {
            alert('Erro ao carregar o board: ' + xhr.responseJSON.message);
            if (xhr.status === 401) window.location.href = '/login';
        });
    }

    loadBoard();
});
</script>
@endsection
