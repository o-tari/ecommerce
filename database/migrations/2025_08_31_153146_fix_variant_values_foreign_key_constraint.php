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
        // Drop the existing variant_values table
        Schema::dropIfExists('variant_values');
        
        // Recreate the variant_values table with proper foreign key constraints
        Schema::create('variant_values', function (Blueprint $table) {
            $table->foreignId('variant_id')->constrained('variants')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();
            $table->foreignId('attribute_value_id')->constrained('attribute_values')->cascadeOnDelete();
            $table->primary(['variant_id', 'product_id', 'attribute_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the fixed variant_values table
        Schema::dropIfExists('variant_values');
        
        // Recreate the original variant_values table
        Schema::create('variant_values', function (Blueprint $table) {
            $table->foreignId('variant_id')->constrained('variants')->cascadeOnDelete();
            $table->foreignId('product_attribute_value_id')->constrained('product_attribute_values')->cascadeOnDelete();
            $table->primary(['variant_id', 'product_attribute_value_id']);
        });
    }
};
