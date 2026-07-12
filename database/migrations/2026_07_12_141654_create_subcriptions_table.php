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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
                ->constrained('shops')
                ->cascadeOnDelete();
            $table->string('plan_name', 100);
            $table->decimal('amount', 12, 2);
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'yearly'])->default;
            $table->date('starts_at');
            $table->date('expires_at');
            $table->string('payment_reference', 255)->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcriptions');
    }
};
