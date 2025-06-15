import $ from 'jquery';
import { loadUserName, setupLogoutButton } from '../helpers/userInfo';

$(document).ready(function() {

    $(document).on('click', '.board-item', function() {
        const boardId = $(this).data('id');
        window.location.href = `/boards/${boardId}`;
    });

    if (!window.location.pathname.startsWith('/boards')) return;

    loadUserName();
    setupLogoutButton();

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    });

    $.get('/api/boards', function(boards) {
        $('#boardsList').empty();

        boards.forEach(function(board) {
            if (board.id && board.name) {
                $('#boardsList').append(`
                    <div class="board-item">
                        <a href="/boards/${board.id}">${board.name}</a>
                    </div>
                `);
            }
        });
    }).fail(function(xhr) {
        alert('Erro ao carregar boards: ' + (xhr.responseJSON?.message || 'Erro desconhecido'));
        if (xhr.status === 401) {
            window.location.href = '/login';
        }
    });

    $(document).on('click', '.board-item', function() {
        const boardId = $(this).data('id');
        window.location.href = `/boards/${boardId}`;
    });

    // Modal de criação de board
    $('#createBoardButton').click(() => $('#boardModalOverlay').fadeIn());
    $('#closeBoardModal').click(() => $('#boardModalOverlay').fadeOut());

    $('#saveBoard').click(function() {
        const boardName = $('#newBoardName').val().trim();
        if (!boardName) {
            alert('Informe um nome para o board');
            return;
        }

        $.ajaxSetup({
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        });

        $.post('/api/boards', { name: boardName }, function() {
            $('#boardModalOverlay').fadeOut();
            location.reload();
        }).fail(function() {
            alert('Erro ao criar board');
        });
    });
});
