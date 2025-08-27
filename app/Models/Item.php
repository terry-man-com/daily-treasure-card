<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'item_name',
        'item_image_path',
        'category_id',
        'rarity_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    // 履歴（たからばこ）で参照される
    public function rewardCollections()
    {
        return $this->hasMany(ChildRewardCollection::class);
    }

    // 選択プール（子どもの景品抽選がされるアイテム群）
    public function rewardSelections()
    {
        return $this->hasMany(ChildRewardSelection::class);
    }
}
