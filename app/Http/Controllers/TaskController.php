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
        $children = auth()->user()->children()->with(['tasks' => function($query) {
            $query->orderBy('id');
        }])->get();
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
                ->withErrors(['contents' => 'お約束を1つ以上入力してください'])
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
        
        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました');
    }

    // 「おやくそく登録」遷移用（タスク編集）
    public function edit()
    {
        // リレーションで取得　+ childに紐づいたtasksも取得する
        $children = auth()->user()->children()->with(['tasks' => function($query) {
            $query->orderBy('id');
        }])->get();
        return view('tasks.edit', compact('children'));
    }

    // バルク更新
    public function bulkUpdate(Request $request)
    {
        $child_id = $request->input('child_id');
        $contents = $request->input('contents', []);
        $update_ids = $request->input('update_ids');

                // 通常のバリデーション
        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'nullable|string|max:15',
            'child_id' => 'required|integer|exists:children,id',
            'update_ids' => 'required|string' // カンマ区切りの文字列として受け取る
        ]);

        // チェックされたタスクのみ更新
        if (!empty($update_ids)) {
            $ids = explode(',', $update_ids);
            
            // 各タスクIDの存在確認とChild_idと照合
            foreach ($ids as $task_id) {
                if (isset($contents[$task_id]) && !empty($contents[$task_id])) {
                    $task = Task::where('id', $task_id)
                        ->where('child_id', $child_id)
                        ->first();

                    if ($task) {
                        $task->update(['contents' => $contents[$task_id]]);
                    }
                }
            }
        }

        return redirect()->route('tasks.index')->with('success', '選択したタスクを更新しました');
    }

    // バルク削除
    public function bulkDelete(Request $request)
    {
        $delete_ids = $request->input('delete_ids');

        if (!empty($delete_ids)) {
            $ids = explode(',', $delete_ids);
            Task::whereIn('id', $ids)->delete();
        }

        return redirect()->route('tasks.edit')->with('success', '選択したタスクを削除しました');
    }
}
