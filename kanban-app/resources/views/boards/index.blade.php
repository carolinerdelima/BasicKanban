@extends('layouts.app')

@section('content')
<h2>Meus Boards</h2>

<ul id="boardsList" class="list-group"></ul>

<script>
$(document).ready(function() {
    // Adiciona o token de autenticação em todas as requisições AJAX
    $.ajaxSetup({
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
    });

    // Pra listar boards do usuário
    $.get('/api/boards', function(boards) {
        $('#boardsList').empty();

        boards.forEach(function(board) {
            $('#boardsList').append(`
                <li class="list-group-item">
                    <a href="/boards/${board.id}" class="text-decoration-none">
                        ${board.name}
                    </a>
                </li>
            `);
        });
    }).fail(function(xhr) {
        alert('Erro ao carregar boards: ' + xhr.responseJSON.message);

        // Se não estiver logado, redireciona para o login
        if (xhr.status === 401) {
            window.location.href = '/login';
        }
    });
});
</script>
@endsection
