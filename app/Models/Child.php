<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
        protected $fillable = [
            'user_id',
            'child_name',
            'child_gender',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
