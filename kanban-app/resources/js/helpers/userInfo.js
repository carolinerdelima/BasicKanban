import $ from 'jquery';

/**
 * Carrega o nome do usuário logado
 */
export function loadUserName() {
    if ($('#loggedUserName').length === 0) return;

    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    });

    $.get('/api/user', function(user) {
        $('#loggedUserName').text(user.name);
    }).fail(function() {
        console.log('Usuário não autenticado. Não carregando nome.');
    });
}


/**
 * Faz o logout e redireciona
 */
export function setupLogoutButton() {
    $('#logoutButton').on('click', function() {
        $.ajaxSetup({
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
        });

        $.post('/api/logout', function() {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }).fail(function() {
            alert('Erro ao realizar logout');
        });
    });
}
