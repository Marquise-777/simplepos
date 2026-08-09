<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(200, 5000);

        $discount = fake()->randomElement([0, 0, 0, 50, 100]);

        $tax = round(($subtotal - $discount) * 0.05, 2);

        return [

            'uuid' => Str::uuid(),

            'shop_id' => Shop::first()->id,

            'user_id' => User::first()->id,

            'customer_id' => fake()->optional(0.8)->randomElement(
                Customer::pluck('id')->toArray()
            ),

            'invoice_no' => 'INV-' . fake()->unique()->numberBetween(100001, 999999),

            'invoice_date' => fake()->dateTimeBetween('-30 days', 'now'),

            'subtotal' => $subtotal,

            'discount' => $discount,

            'tax' => $tax,

            'grand_total' => $subtotal - $discount + $tax,

            'payment_method' => fake()->randomElement([
                'cash',
                'upi',
                'card',
                'bank'
            ]),

            'status' => fake()->randomElement([
                'completed',
                'completed',
                'completed',
                'completed',
                'draft',
                'cancelled'
            ]),

            'notes' => fake()->optional()->sentence(),
        ];
    }
}
