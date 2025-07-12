<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'home'])->name('home');

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth'])->name('dashboard');

// タスク編集ページ遷移用ルーティング（IDが不要のため独自にルーティング設定）
Route::get('/tasks/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::resource('tasks', TaskController::class)
->except(['edit','update']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
