<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\TaskController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('boards', BoardController::class)->only(['index', 'store', 'show']);
    Route::get('/boards/{board}/columns', [ColumnController::class, 'index']);

    Route::apiResource('tasks', TaskController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::patch('/tasks/{task}/move', [TaskController::class, 'move']);
});
