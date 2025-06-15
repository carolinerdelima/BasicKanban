import $ from 'jquery';
import { loadUserName, setupLogoutButton } from '../helpers/userInfo';

$(document).ready(function() {
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
});
