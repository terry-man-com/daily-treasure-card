<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rarity;

class RaritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rarity::upsert([
            ['id' => 1, 'rarity_name' => 'perfect'],
            ['id' => 2, 'rarity_name' => 'partial'],
            ['id' => 3, 'rarity_name' => 'fail'],
        ], ['id'], ['rarity_name']);
    }
}
