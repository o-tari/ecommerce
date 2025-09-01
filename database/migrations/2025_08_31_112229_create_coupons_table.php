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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->decimal('discount_value', 8, 2)->nullable();
            $table->string('discount_type', 50);
            $table->integer('times_used')->default(0);
            $table->integer('max_usage')->nullable();
            $table->decimal('order_amount_limit', 8, 2)->nullable();
            $table->timestamp('coupon_start_date')->nullable();
            $table->timestamp('coupon_end_date')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
