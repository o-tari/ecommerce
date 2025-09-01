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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name', 255);
            $table->string('company', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->text('address_line1');
            $table->text('address_line2')->nullable();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('city', 255)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
