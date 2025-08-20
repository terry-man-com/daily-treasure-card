<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    // 一覧表示
    public function index()
    {
        $children = auth()->user()->children;
        
        return view('children.index', compact('children'));

    }

    // 新規作成画面表示
    public function create()
    {
        $children = auth()->user()->children;
        return view('children.create', compact('children'));
    }

    // 新規作成処理
    public function store(Request $request)
    {
        // 現在の子ども数をチェック
        $currenChildrenCount = auth()->user()->children()->count();
        if ($currenChildrenCount >= 3) {
            return redirect()->back()
                ->withErrors(['limit' => '子どもの登録は3人までです。'])
                ->withInput();
        }
        
        $request->validate([
            'child_name' => 'required|string|max:7',
            'child_gender' => 'required|in:boy,girl',
        ]);

        // 子どもの登録数が３人未満なら登録処理
        auth()->user()->children()->create([
            'child_name' => $request->child_name,
            'child_gender' => $request->child_gender,
        ]);

        return redirect()->route('children.index')->with('success', 'お子さまを登録しました');
    }

    // 編集画面表示
    public function edit()
    {
        $children = auth()->user()->children;
        return view('children.edit', compact('children'));
    }

    // 更新処理
    public function update(Request $request)
    {
        $request->validate([
            'children' => 'required|array',
            'children.*.child_name' => 'required|string|max:7',
            'children.*.gender' => 'required|in:boy,girl',
        ]);

        foreach ($request->children as $childId => $childData) {
            // $childIdは実際のchildのID
            Child::where('id', $childId)
                ->where('user_id', auth()->id()) // セキュリティチェック
                ->update([
                    'child_name' => $childData['child_name'],
                    'child_gender' => $childData['gender'],
                ]);
        }

        return redirect()->route('children.index')->with('success', 'お子さまの名前・性別を更新しました');
    }

    // 削除処理
    public function destroy(Child $child)
    {
        // セキュリティチェック: 認証されたユーザーの子どもかどうか確認
        if ($child->user_id !== auth()->id()) {
            abort(403, 'この操作は許可されていません。');
        }
        
        $child->delete();
        return redirect()->route('children.index')->with('success', 'お子さまを削除しました');
    }
}
