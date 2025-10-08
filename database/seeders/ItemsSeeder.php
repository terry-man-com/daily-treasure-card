<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;


class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // perfect (11件) - rarity_id: 1
            ['item_name' => 'ユニコーン1', 'item_image_path' => '/images/items/cute/ユニコーン1.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => 'ユニコーン2', 'item_image_path' => '/images/items/cute/ユニコーン2.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => 'ユニコーン3', 'item_image_path' => '/images/items/cute/ユニコーン3.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => 'ユニコーン4', 'item_image_path' => '/images/items/cute/ユニコーン4.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => 'ユニコーン5', 'item_image_path' => '/images/items/cute/ユニコーン5.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石1', 'item_image_path' => '/images/items/cute/宝石1.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石2', 'item_image_path' => '/images/items/cute/宝石2.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石3', 'item_image_path' => '/images/items/cute/宝石3.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石群1', 'item_image_path' => '/images/items/cute/宝石群1.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石群2', 'item_image_path' => '/images/items/cute/宝石群2.png', 'category_id' => 1, 'rarity_id' => 1],
            ['item_name' => '宝石群3', 'item_image_path' => '/images/items/cute/宝石群3.png', 'category_id' => 1, 'rarity_id' => 1],
            // partial (5件) - rarity_id: 2
            ['item_name' => '宝石サブ1', 'item_image_path' => '/images/items/cute/宝石サブ1.png', 'category_id' => 1, 'rarity_id' => 2],
            ['item_name' => '宝石サブ2', 'item_image_path' => '/images/items/cute/宝石サブ2.png', 'category_id' => 1, 'rarity_id' => 2],
            ['item_name' => '宝石サブ3', 'item_image_path' => '/images/items/cute/宝石サブ3.png', 'category_id' => 1, 'rarity_id' => 2],
            ['item_name' => '宝石サブ4', 'item_image_path' => '/images/items/cute/宝石サブ4.png', 'category_id' => 1, 'rarity_id' => 2],
            ['item_name' => '宝石サブ5', 'item_image_path' => '/images/items/cute/宝石サブ5.png', 'category_id' => 1, 'rarity_id' => 2],
            // fail （３件） - rarity_id: 3
            ['item_name' => 'カプセル1', 'item_image_path' => '/images/items/fail/カプセル1.png', 'category_id' => 3, 'rarity_id' => 3],
            ['item_name' => 'カプセル2', 'item_image_path' => '/images/items/fail/カプセル2.png', 'category_id' => 3, 'rarity_id' => 3],
            ['item_name' => 'カプセル3', 'item_image_path' => '/images/items/fail/カプセル3.png', 'category_id' => 3, 'rarity_id' => 3],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['item_name' => $item['item_name']],
                $item
            );
        }
    }
}
