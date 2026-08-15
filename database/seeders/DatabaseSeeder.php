<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        Customer::factory(15)->create();

        Sale::factory(50)
            ->create()
            ->each(function ($sale) {

                $sale->items()->createMany(
                    \App\Models\SaleItem::factory()
                        ->count(rand(2, 5))
                        ->make()
                        ->toArray()
                );
            });
        $this->call([
            CreditEmiSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}
