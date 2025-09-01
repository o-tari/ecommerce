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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->text('slug')->unique();
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->decimal('sale_price', 8, 2); // Assuming NUMERIC maps to decimal with appropriate precision and scale
            $table->decimal('compare_price', 8, 2)->default(0);
            $table->decimal('buying_price', 8, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('short_description', 165);
            $table->text('product_description');

            $table->enum('product_type', ['simple', 'variable'])->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('disable_out_of_stock')->default(true);
            $table->text('note')->nullable();

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
        Schema::dropIfExists('products');
    }
};
