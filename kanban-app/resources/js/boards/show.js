import $ from 'jquery';
import Sortable from 'sortablejs';
import { loadUserName, setupLogoutButton } from '../helpers/userInfo';

$(document).ready(() => {
    loadUserName();
    setupLogoutButton();

    const boardId = $('meta[name="board-id"]').attr('content');
    if (!boardId) return;

    $.ajaxSetup({
        headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
    });

    function initDragAndDrop() {
        $('.kanban-tasks').each(function () {
            const $column = $(this).closest('.kanban-column');
            const isDoneColumn = $column.hasClass('done');

            Sortable.create(this, {
                group: 'kanban',
                animation: 150,
                filter: isDoneColumn ? '.kanban-task' : null,
                onMove: function (evt) {
                    const fromIsDone = $(evt.from).closest('.kanban-column').hasClass('done');
                    if (fromIsDone) {
                        return false;
                    }
                },
                onEnd: handleDrop
            });
        });
    }

    function handleDrop(evt) {
        const $item     = $(evt.item);
        const taskId    = $item.data('id');
        const newColumn = $(evt.to).closest('.kanban-column').data('id');
        const newIndex  = evt.newIndex + 1;

        $.ajax({
            url: `/api/tasks/${taskId}/move`,
            method: 'PATCH',
            contentType: 'application/json',
            data: JSON.stringify({
                column_id: newColumn,
                position:  newIndex
            })
        })
        .done(() => {
            loadBoard();
        })
        .fail(xhr => {
            alert('Falha ao mover a task: ' +
                (xhr.responseJSON?.message || 'erro'));
            loadBoard();
        });
    }

    function loadBoard() {
        $.get(`/api/boards/${boardId}/columns`, (columns) => {
            $('#kanbanBoard').empty();

            columns.forEach((column) => {
                const isDone = column.name.toLowerCase() === 'done';

                let columnHtml = `
                    <div class="kanban-column ${isDone ? 'done' : ''}" data-id="${column.id}">
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

            initDragAndDrop();
        });
    }

    loadBoard();
});
