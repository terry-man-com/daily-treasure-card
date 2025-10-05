<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $itemIds = [10, 11, 14];

        DB::table('child_reward_collections')
            ->whereIn('item_id', $itemIds)
            ->delete();

        DB::table('items')
            ->whereIn('id', $itemIds)
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
