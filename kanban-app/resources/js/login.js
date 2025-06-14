import $ from 'jquery';

$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: '/api/login',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            email: $('#email').val(),
            password: $('#password').val(),
        }),
        success: (res) => {
            localStorage.setItem('token', res.token);
            window.location.href = '/boards';
        },
        error: (xhr) => alert(xhr.responseJSON.message),
    });
});
