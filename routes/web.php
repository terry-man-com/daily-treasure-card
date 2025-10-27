<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\RewardController;

Route::get('/', [TaskController::class, 'home'])->name('home');

// 利用規約・プライバシーポリシー・お問い合わせ
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/contact', 'legal.contact')->name('contact');


Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
// タスク管理用ルーティング
// 個別ページ方式（child_id パラメータを受け取る）
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/bulk-update', [TaskController::class, 'bulkUpdate'])->name('tasks.bulkUpdate');
Route::delete('/tasks/bulk-delete', [TaskController::class, 'bulkDelete'])->name('tasks.bulkDelete');

// 子ども管理用ルーティング
Route::get('/children/edit', [ChildController::class, 'edit'])->name('children.edit');
Route::put('/children/update', [ChildController::class, 'update'])->name('children.update');
Route::resource('children', ChildController::class)
->except(['edit','update']);

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
