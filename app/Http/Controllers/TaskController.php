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
    public function index(Request $request)
    {
         // リレーションで取得　+ childに紐づいたtasksも取得する
        $children = auth()->user()->children()->with(['tasks' => function($query) {
            $query->orderBy('id');
        }])->get();
        // 選択された子供を特定
        $selectedChildId = null;
        // セッションから選択された子供IDを取得（優先度：セッション > URLパラメータ）
        if(session('selected_child_id')) {
            $selectedChildId = session('selected_child_id');
            session()->forget('selected_child_id');
        }
        elseif ($request->input('child_id')) {
            // URLパラメータで指定された子供を取得
            $selectedChildId = $request->input('child_id');
        }

        // 選択された子どもが存在しない場合は最初は子供を選択
        if(!$selectedChildId && $children->count() > 0) {
            $selectedChildId = $children->first()->id;
        }

        return view('tasks.index', compact('children', 'selectedChildId'));
    }

    // 「おやくそく登録」遷移用（タスク登録）
    public function create(Request $request)
    {
        $child_id = $request->input('child_id');
        $child = auth()->user()->children()->find($child_id);

        if(!$child) {
            return redirect()->route('tasks.index')->with('error', '子どもが見つかりません');
        }

        // タブ表示用に全ての子どもも渡してあげる
        $children = auth()->user()->children;
        return view('tasks.create', compact('child', 'children'));
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

        // セキュリティチェック: 認証されたユーザーの子どもかどうか確認
        $child = auth()->user()->children()->find($child_id);
        if (!$child) {
            abort(403, 'この操作は許可されていません。');
        }

        foreach ($contents as $content) {
            if (!empty($content)) {
                Task::create([
                    'child_id' => $child_id,
                    'contents' => $content,
                ]);
            } // タスク登録を繰り返す
        }
        // セッションに保存してリダイレクト（URLパラメータなし）
        session(['selected_child_id' => $child_id]);
        return redirect()->route('tasks.index')->with('success', 'お約束を登録しました');
    }

    // 「おやくそく登録」遷移用（タスク編集）
    public function edit(Request $request)
    {
        $child_id = $request->input('child_id');
        // リレーションで取得 + childに紐づいたtasksも取得する
        if($child_id) {
            $child = auth()->user()->children()->with(['tasks' => function($query) {
                $query->orderBy('id');
            }])->find($child_id);

            if(!$child) {
                return redirect()->route('tasks.index')->with('error', '子どもが見つかりません');
            }
        } else {
            // child_idが指定されていない場合は最初の子供を取得
            $child = auth()->user()->children()->with(['tasks' => function($query) {
                $query->orderBy('id');
            }])->first();
        }

        // タブ表示用に全ての子供も渡してあげる
        $children = auth()->user()->children;

        return view('tasks.edit', compact('child', 'children'));
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

        // セキュリティチェック: 認証されたユーザーの子どもかどうか確認
        $child = auth()->user()->children()->find($child_id);
        if (!$child) {
            abort(403, 'この操作は許可されていません。');
        }

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

        // リダイレクトのためにセッション保存
        // セッションに選択された子供IDを保存
        session(['selected_child_id' => $child_id]);

        return redirect()->route('tasks.index')->with('success', 'お約束を更新しました');
    }

    // バルク削除
    public function bulkDelete(Request $request)
    {
        $delete_ids = $request->input('delete_ids');
        $child_id = $request->input('child_id'); 

        if (!empty($delete_ids)) {
            $ids = explode(',', $delete_ids);
            
            // セキュリティチェック: 認証されたユーザーに属する子どものタスクのみ削除
            $userChildrenIds = auth()->user()->children()->pluck('id');
            
            Task::whereIn('id', $ids)
                ->whereIn('child_id', $userChildrenIds)
                ->delete();
        }
        // セッションに選択された子供IDを保存
        if($child_id) {
            session(['selected_child_id' => $child_id]);
        }

        return redirect()->route('tasks.index')->with('success', 'お約束を削除しました');
    }
}
