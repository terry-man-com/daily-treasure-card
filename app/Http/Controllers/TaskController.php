<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // ホーム画面用
    public function home()
    {
        return view('home');
    }
    // 「きょうのおやくそく」画面遷移（タスク一覧）
    public function index() {
        return view('tasks.index');
    }
    // 「」（タスク登録）
    public function create() {
        return view('tasks.create');
    }
}
