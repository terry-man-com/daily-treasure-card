<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildRewardCollection extends Model
{
    // created_at/updated_at は持っていない
    public $timestamps = false;

    protected $fillable = [
        'child_id', 'item_id', 'bucket', 'earned_at', 'reward_selection_id'
    ];

    // earned_at は日時キャスト
    protected $casts = [
        'earned_at' => 'datetime',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // NULL可（プール行が後で消えても履歴は残る想定）
    public function rewardSelection()
    {
        return $this->belongsTo(ChildRewardSelection::class, 'reward_selection_id');
    }

    // 便利スコープ：月範囲
    // public function scopeForMonth($q, \DateTimeInterface $monthStart)
    // {
    //     $start = $monthStart->format('Y-m-01 00:00:00');
    //     $end   = (new \DateTime($start))->modify('last day of this month 23:59:59');
    //     return $q->whereBetween('earned_at', [$start, $end]);
    // }

    // 便利スコープ：子ども＋バケット
    // public function scopeForChildAndBucket($q, int $childId, string $bucket)
    // {
    //     return $q->where('child_id', $childId)->where('bucket', $bucket);
    // }
}
