<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{
    public function definition(): array
    {
        $qty = fake()->randomFloat(2, 1, 5);

        $rate = fake()->randomFloat(2, 20, 1500);

        return [

            'item_name' => fake()->randomElement([
                'Rice',
                'Sugar',
                'Milk',
                'Bread',
                'Egg',
                'Coke',
                'Chocolate',
                'Notebook',
                'Pen',
                'Soap',
                'Shampoo',
                'Cooking Oil',
                'Mobile Charger',
                'USB Cable',
            ]),

            'quantity' => $qty,

            'rate' => $rate,

            'amount' => round($qty * $rate, 2),
        ];
    }
}
