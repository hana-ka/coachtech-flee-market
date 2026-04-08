<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;


class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => '東京都テスト1-1-1',
        ];
    }
}
