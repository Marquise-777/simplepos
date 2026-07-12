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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('invoice_no', 50)->unique();
            $table->dateTime('invoice_date');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2);
            $table->decimal('tax', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->enum('payment_method', ['cash', 'upi', 'bank', 'card', 'mixed'])->default('cash');
            $table->enum('status', ['draft', 'completed', 'cancelled', 'refunded'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
