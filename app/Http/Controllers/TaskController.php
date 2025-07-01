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
    public function index()
    {
        return view('tasks.index');
    }

    // 「おやくそく登録」遷移用（タスク登録）
    public function create()
    {
        
        $children = auth()->user()->children; // リレーションで取得
        return view('tasks.create', compact('children'));
    }

    // タスク登録
    public function store(Request $request)
    {
        $contents = $request->input('contents');

        // フォーム全てが空かどうかを確認
        // if (collect($contents)->filter()->isEmpty()) {
        //     return redirect()->back()
        //         ->withErrors(['contents' => '1つ以上入力してください'])
        //         ->withInput();
        // }

        // 通常のバリデーション
        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'nullable|string|max:15',
        ]);
        foreach ($contents as $content) {
            if (!empty($content)) {
                Task::create(['contents' => $content]);
            } // タスク登録を繰り返す
        }
        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました！');
    }

}
