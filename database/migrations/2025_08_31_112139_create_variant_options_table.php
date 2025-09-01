<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variant_options', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('sale_price', 8, 2)->default(0);
            $table->decimal('compare_price', 8, 2)->default(0);
            $table->decimal('buying_price', 8, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('sku')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_options');
    }
};
