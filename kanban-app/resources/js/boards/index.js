import $ from 'jquery';
import { loadUserName, setupLogoutButton } from '../helpers/userInfo';

$(document).ready(() => {
    if (!window.location.pathname.startsWith('/boards')) {
        return;
    }

    loadUserName();
    setupLogoutButton();

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    });

    $.get('/api/boards')
        .done(boards => {
            const $list = $('#boardsList').empty();

            boards.forEach(board => {
                $list.append(`
                    <div class="board-item" data-id="${board.id}">
                        ${board.name}
                    </div>
                `);
            });
        })
        .fail(xhr => {
            alert('Erro ao carregar boards: '
                + (xhr?.responseJSON?.message || 'Erro desconhecido'));

            if (xhr.status === 401) window.location.href = '/login';
        });

    $(document).on('click', '.board-item', function () {
        const boardId = $(this).data('id');
        if (boardId) window.location.href = `/boards/${boardId}`;
    });

    $('#createBoardButton').on('click', () => $('#boardModalOverlay').fadeIn());
    $('#closeBoardModal').on('click', () => $('#boardModalOverlay').fadeOut());

    $('#saveBoard').on('click', () => {
        const boardName = $('#newBoardName').val().trim();

        if (!boardName) {
            alert('Informe um nome para o board');
            return;
        }

        $.post('/api/boards', { name: boardName })
            .done(() => {
                $('#boardModalOverlay').fadeOut();
                location.reload();               // recarrega lista
            })
            .fail(() => alert('Erro ao criar board'));
    });
});
