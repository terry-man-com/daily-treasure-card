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
        return view('children.create');
    }

    // 新規作成処理
    public function store(Request $request)
    {
        $request->validate([
            'child_name' => 'required|string|max:20',
            'gender' => 'required|in:男の子,女の子',
        ]);

        auth()->user()->children()->create([
            'child_name' => $request->child_name,
            'gender' => $request->gender,
        ]);

        return redirect()->route('children.index')->with('success', '子供を登録しました！');
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

        return redirect()->route('children.index')->with('success', '更新しました！');
    }

    // 削除処理
    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->route('children.index')->with('success', '削除しました！');
    }
}
