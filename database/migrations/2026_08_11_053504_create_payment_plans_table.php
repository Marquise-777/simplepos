<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')
                ->unique()
                ->constrained('sales')
                ->cascadeOnDelete();

            $table->enum('type', [
                'mutual',
                'financer',
            ]);

            $table->string('financer_name', 150)->nullable();

            $table->decimal('down_payment', 12, 2)->default(0);

            $table->decimal('principal_amount', 12, 2);

            $table->decimal('total_payable', 12, 2);

            $table->decimal('installment_amount', 12, 2);

            $table->unsignedInteger('installment_count');

            $table->enum('frequency', [
                'weekly',
                'monthly',
                'custom',
            ]);

            $table->date('start_date');

            $table->enum('status', [
                'active',
                'completed',
                'cancelled',
            ])->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
