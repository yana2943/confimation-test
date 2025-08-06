<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
    'content' => $this->faker->randomElement([
        '1. 商品のお届けについて',
        '2. 商品の交換について',
        '3. 商品トラブル',
        '4. ショップへのお問い合わせ',
        '5. その他',
    ]),
];
    }
}
