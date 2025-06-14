import $ from 'jquery';

$(document).ready(function() {
    const boardId = $('meta[name="board-id"]').attr('content');

    // Só executa se estiver na página de show de board
    if (!boardId) return;

    // Configura o token de autenticação
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
                    <div class="kanban-column">
                        <div class="kanban-column-header">${column.name}</div>
                        <div class="kanban-tasks">
                `;

                column.tasks.forEach(function(task) {
                    columnHtml += `
                        <div class="kanban-task">
                            <strong>${task.title}</strong><br>
                            ${task.description || ''}
                        </div>
                    `;
                });

                columnHtml += `
                        </div> <!-- Fim das tasks -->
                    </div> <!-- Fim da coluna -->
                `;

                $('#kanbanBoard').append(columnHtml);
            });
        }).fail(function(xhr) {
            alert('Erro ao carregar o board: ' + (xhr.responseJSON?.message || 'Erro desconhecido'));
            if (xhr.status === 401) window.location.href = '/login';
        });
    }

    loadBoard();
});
