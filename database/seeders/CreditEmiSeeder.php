<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\PaymentInstallment;
use App\Models\PaymentPlan;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CreditEmiSeeder extends Seeder
{
    public function run(): void
    {
        $shopId = 1; // your shop ID

        $customer = Customer::where('shop_id', $shopId)->first();

        $sale = Sale::where('shop_id', $shopId)
            ->where('customer_id', $customer?->id)
            ->first();

        if (!$customer || !$sale) {
            $this->command->error('Customer or Sale not found.');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | MUTUAL AGREEMENT
        |--------------------------------------------------------------------------
        */

        $mutualSale = Sale::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'shop_id' => $shopId,
            'user_id' => 1,
            'customer_id' => $customer->id,
            'invoice_no' => 'INV-MUTUAL-001',
            'invoice_date' => now(),
            'subtotal' => 30000,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 30000,
            'payment_method' => 'cash',
            'status' => 'completed',
        ]);

        SalePayment::create([
            'sale_id' => $mutualSale->id,
            'amount' => 10000,
            'payment_method' => 'cash',
            'paid_at' => now(),
            'notes' => 'Down payment',
        ]);

        $mutualPlan = PaymentPlan::create([
            'sale_id' => $mutualSale->id,
            'type' => 'mutual',
            'financer_name' => null,
            'down_payment' => 10000,
            'principal_amount' => 20000,
            'total_payable' => 20000,
            'installment_amount' => 5000,
            'installment_count' => 4,
            'frequency' => 'monthly',
            'start_date' => today(),
            'status' => 'active',
            'notes' => 'Mutual payment agreement',
        ]);

        for ($i = 1; $i <= 4; $i++) {
            PaymentInstallment::create([
                'payment_plan_id' => $mutualPlan->id,
                'due_date' => today()->addMonths($i),
                'amount' => 5000,
                'paid_amount' => 0,
                'status' => 'pending',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FINANCER / EMI
        |--------------------------------------------------------------------------
        */

        $emiSale = Sale::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'shop_id' => $shopId,
            'user_id' => 1,
            'customer_id' => $customer->id,
            'invoice_no' => 'INV-EMI-001',
            'invoice_date' => now(),
            'subtotal' => 50000,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 50000,
            'payment_method' => 'bank',
            'status' => 'completed',
        ]);

        SalePayment::create([
            'sale_id' => $emiSale->id,
            'amount' => 10000,
            'payment_method' => 'bank',
            'paid_at' => now(),
            'notes' => 'Down payment',
        ]);

        $emiPlan = PaymentPlan::create([
            'sale_id' => $emiSale->id,
            'type' => 'financer',
            'financer_name' => 'ABC Finance',
            'down_payment' => 10000,
            'principal_amount' => 40000,
            'total_payable' => 40000,
            'installment_amount' => 4000,
            'installment_count' => 10,
            'frequency' => 'monthly',
            'start_date' => today(),
            'status' => 'active',
            'notes' => '10 month financer EMI',
        ]);

        for ($i = 1; $i <= 10; $i++) {
            PaymentInstallment::create([
                'payment_plan_id' => $emiPlan->id,
                'due_date' => today()->addMonths($i),
                'amount' => 4000,
                'paid_amount' => 0,
                'status' => 'pending',
            ]);
        }

        $this->command->info('Credit & EMI test data created successfully.');
    }
}
