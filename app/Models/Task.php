<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
            'child_id',
            'contents',
    ];

        public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
