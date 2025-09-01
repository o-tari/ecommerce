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
        Schema::create('variant_values', function (Blueprint $table) {
            $table->foreignId('variant_id')->constrained('variants')->cascadeOnDelete();
            $table->foreignId('product_attribute_value_id')->constrained('product_attribute_values')->cascadeOnDelete();
            $table->primary(['variant_id', 'product_attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_values');
    }
};
