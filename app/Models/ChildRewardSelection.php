<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildRewardSelection extends Model
{
    protected $fillable = [
        'child_id',
        'item_id',
        'rarity_id',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    // 逆参照（履歴→どの選択行から当選したか）を巡りたい場合に使う。
    public function rewardCollections()
    {
        return $this->hasMany(ChildRewardCollection::class, 'reward_selection_id');
    }
}
