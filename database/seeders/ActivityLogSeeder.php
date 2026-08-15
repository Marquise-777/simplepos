<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::with('shop')->first();

        if (!$user || !$user->shop) {
            return;
        }

        $actions = [
            [
                'action' => 'shop_created',
                'description' => 'Shop was created successfully.',
            ],
            [
                'action' => 'shop_setup_completed',
                'description' => 'Business setup was completed.',
            ],
            [
                'action' => 'sale_created',
                'description' => 'Invoice SIM-1001 was completed successfully.',
            ],
            [
                'action' => 'sale_created',
                'description' => 'Invoice SIM-1002 was completed successfully.',
            ],
            [
                'action' => 'payment_received',
                'description' => 'Payment of ₹1,500 was received.',
            ],
            [
                'action' => 'credit_created',
                'description' => 'A new credit sale was recorded.',
            ],
            [
                'action' => 'sale_cancelled',
                'description' => 'Invoice SIM-1003 was cancelled.',
            ],
            [
                'action' => 'sale_refunded',
                'description' => 'Invoice SIM-1004 was refunded.',
            ],
        ];

        foreach ($actions as $activity) {
            ActivityLog::create([
                'shop_id' => $user->shop_id,
                'user_id' => $user->id,
                'action' => $activity['action'],
                'description' => $activity['description'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'read_at' => null,
            ]);
        }

        // Additional sale notifications for testing infinite scroll
        for ($i = 1; $i <= 20; $i++) {
            ActivityLog::create([
                'shop_id' => $user->shop_id,
                'user_id' => $user->id,
                'action' => 'sale_created',
                'description' => "Test invoice SIM-TEST-" . str_pad($i, 3, '0', STR_PAD_LEFT) . " was completed successfully.",
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'read_at' => null,
            ]);
        }
    }
}
