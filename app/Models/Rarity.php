<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $fillable = [
        'rarity_name'
    ];

    // ★ 唯一の定数（正しい名前を一元管理）
    public const PERFECT = 'perfect';
    public const PARTIAL = 'partial';
    public const FAIL    = 'fail';

    public static function allNames(): array
    {
        return [self::PERFECT, self::PARTIAL, self::FAIL];
    }

    public function selections()
    {
        return $this->hasMany(ChildRewardSelection::class);
    }

        public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
