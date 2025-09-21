<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildRewardCollection extends Model
{
    use HasFactory;
    
    // created_at/updated_at は持っていない
    public $timestamps = false;

    protected $fillable = [
        'child_id', 'item_id', 'earned_at', 'reward_selection_id'
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

    // // NULL可（プール行が後で消えても履歴は残る想定）
    // public function rewardSelection()
    // {
    //     return $this->belongsTo(ChildRewardSelection::class, 'reward_selection_id');
    // }
}
