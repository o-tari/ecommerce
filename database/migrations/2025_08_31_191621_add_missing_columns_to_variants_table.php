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
        Schema::table('variants', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('variant_option_id');
            $table->decimal('price', 10, 2)->default(0)->after('sku');
            $table->integer('quantity')->default(0)->after('price');
            $table->decimal('weight', 10, 2)->default(0)->after('quantity');
            $table->boolean('is_active')->default(true)->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->dropColumn(['sku', 'price', 'quantity', 'weight', 'is_active']);
        });
    }
};
