<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::upsert([
            ['id' => 1, 'category_name' => 'かわいい'],
            ['id' => 2, 'category_name' => 'かっこいい'],
            ['id' => 3, 'category_name' => 'ハズレ'],
        ], ['id'], ['category_name']);
    }
}
