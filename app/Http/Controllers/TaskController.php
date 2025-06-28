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
    
    public function index() {
        return view('tasks.index');
    }

    public function create() {
        return view('tasks.create');
    }
}
