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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('order_status_id')->nullable()->constrained('order_statuses')->cascadeOnDelete();
            $table->timestamp('order_approved_at')->nullable();
            $table->timestamp('order_delivered_carrier_date')->nullable();
            $table->timestamp('order_delivered_customer_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
