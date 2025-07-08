<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
         // リレーションで取得　+ childに紐づいたtasksも取得する
        $children = auth()->user()->children()->with('tasks')->get();
        return view('tasks.index', compact('children'));
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
        $child_id = $request->input('child_id');
        $contents = $request->input('contents');

        // フォーム全てが空かどうかを確認
        if (collect($contents)->filter()->isEmpty()) {
            return redirect()->back()
                ->withErrors(['contents' => '1つ以上入力してください'])
                ->withInput();
        }

        // 通常のバリデーション
        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'nullable|string|max:15',
            'child_id' => 'required|integer|exists:children,id',
        ]);

        foreach ($contents as $content) {
            if (!empty($content)) {
                Task::create([
                    'child_id' => $child_id,
                    'contents' => $content,
                ]);
            } // タスク登録を繰り返す
        }
        
        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました！');
    }

}
