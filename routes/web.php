<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\RewardController;

Route::get('/', [TaskController::class, 'home'])->name('home');

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth'])->name('dashboard');


// タスク管理用ルーティング管理
// タスク編集ページ遷移用ルーティング（IDが不要のため独自にルーティング設定）
Route::get('/tasks/edit', [TaskController::class, 'edit'])->name('tasks.edit');
// バルク更新・削除用ルート
Route::put('/tasks/bulk-update', [TaskController::class, 'bulkUpdate'])->name('tasks.bulkUpdate');
Route::delete('/tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulkDelete');
// タスク管理用ルーティングここまで
Route::resource('tasks', TaskController::class)
->except(['edit','update','destroy']);

// 子ども管理用ルーティング管理
// 子ども編集用ページ遷移
Route::get('/children/edit', [ChildController::class, 'edit'])->name('children.edit');
// バルク更新用ルート￥
Route::put('/children/update', [ChildController::class, 'update'])->name('children.update');
// 子ども管理用ルーティングここまで
Route::resource('children', ChildController::class)
->except(['edit','update',]);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ガチャ機能のルート
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
    Route::post('/gacha/draw', [RewardController::class, 'drawGacha'])->name('gacha.draw');
    
    // FullCalendar用API
    Route::get('/api/rewards/{childId}/events', [RewardController::class, 'getEvents']);
    Route::get('/api/rewards/{childId}/{date}', [RewardController::class, 'getRewardsByDate']);
});

require __DIR__.'/auth.php';
