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
        Schema::create('product_shipping_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->decimal('weight', 10, 2)->default(0); // weight NUMERIC NOT NULL DEFAULT 0
            $table->string('weight_unit', 10); // weight_unit VARCHAR(10)
            $table->decimal('volume', 10, 2)->default(0); // volume NUMERIC NOT NULL DEFAULT 0
            $table->string('volume_unit', 10); // volume_unit VARCHAR(10)
            // CHECK (volume_unit IN ('l', 'ml')) - See comment for weight_unit.
            $table->decimal('dimension_width', 10, 2)->default(0); // dimension_width NUMERIC NOT NULL DEFAULT 0
            $table->decimal('dimension_height', 10, 2)->default(0); // dimension_height NUMERIC NOT NULL DEFAULT 0
            $table->decimal('dimension_depth', 10, 2)->default(0); // dimension_depth NUMERIC NOT NULL DEFAULT 0
            $table->string('dimension_unit', 10); // dimension_unit VARCHAR(10)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shipping_infos');
    }
};
