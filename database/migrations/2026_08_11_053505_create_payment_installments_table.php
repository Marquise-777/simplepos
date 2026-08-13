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
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_plan_id')
                ->constrained('payment_plans')
                ->cascadeOnDelete();

            $table->date('due_date');

            $table->decimal('amount', 12, 2);

            $table->decimal('paid_amount', 12, 2)
                ->default(0);

            $table->enum('status', [
                'pending',
                'partial',
                'paid',
                'overdue',
            ])->default('pending');

            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_installments');
    }
};
