<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function() {
    return view('auth.login');
});

Route::get('/boards', function() {
    return view('boards.index');
});

Route::get('/boards/{board}', function ($boardId) {
    return view('boards.show', ['boardId' => $boardId]);
});