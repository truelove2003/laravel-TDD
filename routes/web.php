<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::post('/tasks', [TaskController::class, 'store']); // Thêm task
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // Sửa task
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); // Xoá task
    Route::get('/tasks/{task}', [TaskController::class, 'show']); // Xem chi tiết task
});
