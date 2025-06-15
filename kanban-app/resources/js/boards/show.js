import $ from 'jquery';
import Sortable from 'sortablejs';

$(document).ready(() => {
    const boardId = $('meta[name="board-id"]').attr('content');
    if (!boardId) return;

    $.ajaxSetup({
        headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
    });

    function initDragAndDrop() {
        // Para cada lista de tasks
        $('.kanban-tasks').each(function () {
            Sortable.create(this, {
                group: 'kanban', // permite arrastar entre colunas
                animation: 150,
                onEnd: handleDrop
            });
        });
    }

    /** Enviado sempre que um card muda */
    function handleDrop(evt) {
        const $item      = $(evt.item); // card arrastado
        const taskId     = $item.data('id');
        const newColumn  = $(evt.to).closest('.kanban-column').data('id');
        const newIndex   = evt.newIndex + 1;

        $.ajax({
            url: `/api/tasks/${taskId}/move`,
            method: 'PATCH',
            contentType: 'application/json',
            data: JSON.stringify({ column_id: newColumn, position: newIndex })
        }).fail((xhr) => {
            alert('Falha ao mover a task: ' + (xhr.responseJSON?.message || 'erro'));
        });
    }

    // carrega e desenha o board
    function loadBoard() {
        $.get(`/api/boards/${boardId}/columns`, (columns) => {
            $('#kanbanBoard').empty();

            columns.forEach((column) => {
                let columnHtml = `
                    <div class="kanban-column" data-id="${column.id}">
                        <div class="kanban-column-header">${column.name}</div>
                        <div class="kanban-tasks">
                `;

                column.tasks.forEach((task) => {
                    columnHtml += `
                        <div class="kanban-task" data-id="${task.id}">
                            <strong>${task.title}</strong>
                            <span>${task.description ?? ''}</span>
                        </div>
                    `;
                });

                columnHtml += `
                        </div>
                    </div>
                `;

                $('#kanbanBoard').append(columnHtml);
            });

            initDragAndDrop(); // ativa SortableJS depois de renderizar
        });
    }

    loadBoard();
});
