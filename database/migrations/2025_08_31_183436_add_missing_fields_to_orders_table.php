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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->unique()->after('id');
            $table->decimal('subtotal', 10, 2)->after('order_status_id');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('shipping_amount', 10, 2)->default(0)->after('tax_amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('shipping_amount');
            $table->decimal('total_amount', 10, 2)->after('discount_amount');
            $table->text('shipping_address')->nullable()->after('total_amount');
            $table->text('billing_address')->nullable()->after('shipping_address');
            $table->text('notes')->nullable()->after('billing_address');
            $table->string('payment_method')->nullable()->after('notes');
            $table->string('payment_status')->nullable()->after('payment_method');
            $table->string('shipping_method')->nullable()->after('payment_status');
            $table->string('tracking_number')->nullable()->after('shipping_method');
            $table->foreignId('shipping_address_id')->nullable()->constrained('customer_addresses')->after('tracking_number');
            $table->foreignId('billing_address_id')->nullable()->constrained('customer_addresses')->after('shipping_address_id');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->after('billing_address_id');
            $table->timestamp('updated_at')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id', 'billing_address_id', 'created_by']);
            $table->dropColumn([
                'order_number',
                'subtotal',
                'tax_amount',
                'shipping_amount',
                'discount_amount',
                'total_amount',
                'shipping_address',
                'billing_address',
                'notes',
                'payment_method',
                'payment_status',
                'shipping_method',
                'tracking_number',
                'shipping_address_id',
                'billing_address_id',
                'created_by',
                'updated_at'
            ]);
        });
    }
};
