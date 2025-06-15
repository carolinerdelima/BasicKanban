import $              from 'jquery';
import Sortable       from 'sortablejs';
import { loadUserName, setupLogoutButton } from '../helpers/userInfo';

$(document).ready(() => {

    loadUserName();
    setupLogoutButton();

    const boardId = $('meta[name="board-id"]').attr('content');
    if (!boardId) return;

    $.ajaxSetup({
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
    });

    let todoColumnId = null;

    function initDragAndDrop () {
        $('.kanban-tasks').each(function () {
            const $column      = $(this).closest('.kanban-column');
            const isDoneColumn = $column.hasClass('done');

            Sortable.create(this, {
                group     : 'kanban',
                animation : 150,
                filter    : isDoneColumn ? '.kanban-task' : null,
                onMove    : evt => {
                    // impede mover SAINDO de Done
                    const fromDone = $(evt.from).closest('.kanban-column').hasClass('done');
                    if (fromDone) return false;
                },
                onEnd: handleDrop
            });
        });
    }

    function handleDrop (evt) {
        const $item     = $(evt.item);
        const taskId    = $item.data('id');
        const newColumn = $(evt.to).closest('.kanban-column').data('id');
        const newIndex  = evt.newIndex + 1;

        $.ajax({
            url  : `/api/tasks/${taskId}/move`,
            type : 'PATCH',
            contentType: 'application/json',
            data : JSON.stringify({ column_id: newColumn, position: newIndex })
        })
        .always(loadBoard);
    }

    function loadBoard () {
        $.get(`/api/boards/${boardId}/columns`, columns => {
            $('#kanbanBoard').empty();
            todoColumnId = null;

            columns.forEach(col => {
                const isDone = col.name.toLowerCase() === 'done';
                if (!todoColumnId && col.name.toLowerCase() === 'to do') {
                    todoColumnId = col.id;
                }

                let html = /* html */`
                    <div class="kanban-column ${isDone ? 'done' : ''}" data-id="${col.id}">
                        <div class="kanban-column-header">${col.name}</div>
                        <div class="kanban-tasks">
                `;

                col.tasks.forEach(task => {
                    html += /* html */`
                        <div class="kanban-task" data-id="${task.id}">
                            <strong>${task.title}</strong>
                            <span>${task.description ?? ''}</span>
                        </div>`;
                });

                html += /* html */`
                        </div>
                    </div>`;
                $('#kanbanBoard').append(html);
            });

            initDragAndDrop();
        });
    }

    loadBoard();

    $('#createTaskButton').on('click', () => $('#taskModalOverlay').fadeIn());
    $('#closeTaskModal') .on('click', () => $('#taskModalOverlay').fadeOut());

    $('#saveTask').on('click', () => {
        const title = $('#taskTitle').val().trim();
        const desc  = $('#taskDescription').val().trim();

        if (!title) { alert('Informe um título'); return; }
        if (!todoColumnId) { alert('Coluna "To Do" não encontrada'); return; }

        $.post('/api/tasks', {
            title       : title,
            description : desc,
            column_id   : todoColumnId
        })
        .done(() => { $('#taskModalOverlay').fadeOut(); loadBoard(); })
        .fail(()  =>   alert('Erro ao criar task'));
    });
});
