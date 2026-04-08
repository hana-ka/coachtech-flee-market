<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;
use App\Models\Condition;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => 1000,
            'description' => $this->faker->sentence,
            'brand' => 'test',
            'image' => 'test.jpg',
            'condition_id' => Condition::first()->id,
            'user_id' => User::factory(),
        ];
    }
}
