import $ from 'jquery';

$(document).ready(function () {
    // Captura o ID do board
    const boardId = $('meta[name="board-id"]').attr('content');
    if (!boardId) return; // Se não estiver na página correta, sai

    // Token de autenticação em todas as requisições
    $.ajaxSetup({
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token'),
        },
    });

    // ========================
    // Carrega colunas + tasks
    // ========================
    function loadBoard() {
        $.get(`/api/boards/${boardId}/columns`, (columns) => {
            $('#kanbanBoard').empty();

            columns.forEach((column) => {
                let columnHtml = `
                    <div class="kanban-column">
                        <div class="kanban-column-header">${column.name}</div>
                        <div class="kanban-tasks">
                `;

                column.tasks.forEach((task) => {
                    columnHtml += `
                        <div class="kanban-task">
                            <strong>${task.title}</strong>
                            <span>${task.description ?? ''}</span>
                        </div>
                    `;
                });

                columnHtml += `
                        </div> <!-- /kanban-tasks -->
                    </div> <!-- /kanban-column -->
                `;

                $('#kanbanBoard').append(columnHtml);
            });
        }).fail((xhr) => {
            alert(
                'Erro ao carregar o board: ' +
                    (xhr.responseJSON?.message || 'Erro desconhecido')
            );
            if (xhr.status === 401) window.location.href = '/login';
        });
    }

    loadBoard();
});
