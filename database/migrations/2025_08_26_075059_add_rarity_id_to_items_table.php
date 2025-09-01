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
        Schema::table('items', function (Blueprint $table) {
            // 1. まずnullable（null許可）でカラムを追加
            $table->foreignId('rarity_id')->nullable()->after('category_id')->constrained()->cascadeOnDelete();
        });

        // 2. 既存データにデフォルト値を設定
        // 既存のアイテムを適切なレアリティに振り分け
        $this->assignRarityToExistingItems();

        // 3. NOT NULL制約を追加
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('rarity_id')->nullable(false)->change();
        });
    }

    /**
     * 既存アイテムにレアリティを割り当て
     */
    private function assignRarityToExistingItems()
    {
        // テスト環境では既存アイテムがない場合は何もしない
        $itemCount = \DB::table('items')->count();
        if ($itemCount === 0) {
            return;
        }

        // Rarityテーブルからレアリティを取得
        $perfectRarity = \DB::table('rarities')->where('rarity_name', 'perfect')->first();
        $partialRarity = \DB::table('rarities')->where('rarity_name', 'partial')->first();
        $failRarity = \DB::table('rarities')->where('rarity_name', 'fail')->first();

        if (!$perfectRarity || !$partialRarity || !$failRarity) {
            // テスト環境では基本的なレアリティを自動作成
            if (!$perfectRarity) {
                $perfectRarity = (object)['id' => \DB::table('rarities')->insertGetId(['rarity_name' => 'perfect'])];
            }
            if (!$partialRarity) {
                $partialRarity = (object)['id' => \DB::table('rarities')->insertGetId(['rarity_name' => 'partial'])];
            }
            if (!$failRarity) {
                $failRarity = (object)['id' => \DB::table('rarities')->insertGetId(['rarity_name' => 'fail'])];
            }
        }

        // 既存アイテムの名前に基づいてレアリティを割り当て
        $itemMappings = [
            // perfect用アイテム
            'ユニコーン1' => $perfectRarity->id,
            'ユニコーン2' => $perfectRarity->id,
            'ユニコーン3' => $perfectRarity->id,
            'ユニコーン4' => $perfectRarity->id,
            'ユニコーン5' => $perfectRarity->id,
            '宝石1' => $perfectRarity->id,
            '宝石2' => $perfectRarity->id,
            '宝石3' => $perfectRarity->id,
            '宝石群1' => $perfectRarity->id,
            '宝石群2' => $perfectRarity->id,
            '宝石群3' => $perfectRarity->id,
            
            // partial用アイテム
            '宝石サブ1' => $partialRarity->id,
            '宝石サブ2' => $partialRarity->id,
            '宝石サブ3' => $partialRarity->id,
            '宝石サブ4' => $partialRarity->id,
            '宝石サブ5' => $partialRarity->id,
            
            // fail用アイテム
            'カプセル1' => $failRarity->id,
            'カプセル2' => $failRarity->id,
            'カプセル3' => $failRarity->id,
        ];

        foreach ($itemMappings as $itemName => $rarityId) {
            \DB::table('items')
                ->where('item_name', $itemName)
                ->update(['rarity_id' => $rarityId]);
        }

        // 上記のマッピングにない既存アイテムがある場合はpartialに設定
        \DB::table('items')
            ->whereNull('rarity_id')
            ->update(['rarity_id' => $partialRarity->id]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['rarity_id']);
            $table->dropColumn('rarity_id');
        });
    }
};
