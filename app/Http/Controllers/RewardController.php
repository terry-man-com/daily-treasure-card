<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Item;
use App\Models\Rarity;
use App\Models\ChildRewardCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    /**
     * 景品履歴表示（シンプル版 - パラメータなし）
     */
    public function index()
    {
        $user = Auth::user();
        $children = $user->children()->with(['rewardCollections.item.category', 'rewardCollections.item.rarity'])->get();
        // 最初の子どもをデフォルト選択
        $selectedChild = $children->first();

        return view('rewards.index', compact('children', 'selectedChild'));
    }

    /**
     * ガチャ実行（シンプル版 - パラメータなし）
     */
    public function drawGacha(Request $request)
    {
        $request->validate([
            'child_id' => 'required|integer',
            'true_count' => 'required|integer|min:0',
            'total_tasks' => 'required|integer|min:1',
        ]);

        $childId = $request->input('child_id');
        $trueCount = $request->input('true_count');
        $totalTasks = $request->input('total_tasks');

        // 子どもの存在確認
        $child = Child::where('id', $childId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // レアリティを決定
        $rarity = $this->determineRarity($trueCount, $totalTasks);

        // 該当レアリティからアイテムを抽選
        $items = Item::where('rarity_id', $rarity->id)->get();

        if ($items->isEmpty()) {
            return response()->json(['error' => '該当するアイテムが見つかりません'], 400);
        }

        $selectedItem = $items->random();

        // 🔥 日別でガチャ制限を実装
        $today = now()->startOfDay();
        $tomorrow = now()->startOfDay()->addDay();

        // 今日のガチャ記録を検索
        $existingReward = ChildRewardCollection::where('child_id', $childId)
            ->whereBetween('earned_at', [$today, $tomorrow])
            ->first();

        if ($existingReward) {
            // 更新
            $existingReward->update([
                'item_id' => $selectedItem->id,
                'earned_at' => now(),
            ]);
            $rewardCollection = $existingReward;
            $isNewRecord = false;
        } else {
            // 新規作成
            $rewardCollection = ChildRewardCollection::create([
                'child_id' => $childId,
                'item_id' => $selectedItem->id,
                'earned_at' => now(),
            ]);
            $isNewRecord = true;
        }

        // フロント側で表示するためのJSON返却
        return response()->json([
            'success' => true,
            'is_new' => $isNewRecord, // フロントで「初回」「更新」を区別可能
            'message' => $isNewRecord ? '今日の宝物をゲット！' : '今日の宝物を更新しました！',
            'item' => [
                'id' => $selectedItem->id,
                'item_name' => $selectedItem->item_name,
                'item_image_path' => $selectedItem->item_image_path,
            ],
            'rarity' => $rarity->rarity_name,
            'earned_at' => $rewardCollection->earned_at->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * レアリティ判定ロジック
     */
    private function determineRarity($trueCount, $totalTasks)
    {
        if ($trueCount === $totalTasks) {
            // 全タスク達成
            return Rarity::where('rarity_name', 'perfect')->first();
        } elseif ($trueCount > 0) {
            // 一部タスク達成
            return Rarity::where('rarity_name', 'partial')->first();
        } else {
            // 全タスク未達成
            return Rarity::where('rarity_name', 'fail')->first();
        }
    }

    /**
     * FullCalender用のイベントデータ取得
     */
    public function getEvents(Request $request, $childId)
    {
        try {
            $start = $request->input('start');
            $end = $request->input('end');

            // 日時フォーマットを修正
            $start = substr($start, 0, 10) . ' 00:00:00';
            $end = substr($end, 0, 10) . ' 23:59:59';

            $child = Child::where('id', $childId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$child) {
                return response()->json(['error' => 'Child not found'], 404);
            }

            $rewards = $child->rewardCollections()
                ->with(['item.category', 'item.rarity'])
                ->whereBetween('earned_at',[$start, $end])
                ->get();

            // FullCalendar形式に変換（flower-stamp仕様）
            // extentedPropsはカスタムデータ
            $events = $rewards->map(function($reward) {
                return [
                    'id' => $reward->id,
                    'title' => $reward->item->item_name,
                    'start' => $reward->earned_at->toISOString(),
                    'extendedProps' => [
                        'hasGacha' => true, // ガチャ実行日フラグ
                        'item' => $reward->item,
                        'rarity' => $reward->item->rarity,
                        'earned_at' => $reward->earned_at
                    ]
                ];
            });

            return response()->json($events);

        } catch (\Exception $e) {
            \Log::error('getEvents error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * 日別景品取得API（カレンダーのモーダル表示用）
     * 特定の日付の景品一覧をJSONで返す
     */
    public function getRewardsByDate(Request $request, $childId, $date)
    {
        $child = Child::where('id', $childId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $rewards = $child->rewardCollections()
            ->with(['item.category', 'item.rarity'])
            ->whereDate('earned_at', $date)
            ->orderBy('earned_at', 'desc')
            ->get();

        return response()->json($rewards);
    }

    /**
     * レアリティに応じた色を取得
     */
    private function getRarityColor($rarityName)
    {
        return match($rarityName) {
            'perfect' => '#FFD700', // ゴールド
            'partial' => '#87CEEB', // スカイブルー
            'fail' => '#DDA0DD',    // プラム
            default => '#CCCCCC'
        };
    }
}
