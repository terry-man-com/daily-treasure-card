<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name' => $this->faker->word() . 'アイテム',
            'item_image_path' => '/test/' . $this->faker->word() . '.png',
            'category_id' => \App\Models\Category::factory(),
            'rarity_id' => \App\Models\Rarity::factory(),
        ];
    }
}
