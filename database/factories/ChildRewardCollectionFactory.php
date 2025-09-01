<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildRewardCollection>
 */
class ChildRewardCollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_id' => Child::factory(),
            'item_id' => Item::factory(),
            'earned_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
