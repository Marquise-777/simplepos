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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('business_name', 150);
            $table->string('logo', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('address')->nullable();
            $table->string('invoice_prefix', 20);
            $table->enum('invoice_template', ['classic', 'modern', 'thermal58', 'thermal80', 'a4'])->default('classic');
            $table->enum('paper_size', ['thermal58', 'thermal80', 'a4'])->default('thermal58');
            $table->string('currency', 10);
            $table->string('timezone', 100);
            $table->string('date_format', 30);
            $table->string('gst', 100)->nullable();
            $table->string('fssai', 100)->nullable();
            $table->text('footer_text')->nullable();
            $table->string('primary_color', 20)->default('#2563eb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
