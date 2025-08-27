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
        Schema::table('child_reward_collections', function (Blueprint $table) {
            $table->dropColumn('bucket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('child_reward_collections', function (Blueprint $table) {
            $table->string('bucket', 16)->after('item_id');
        });
    }
};
