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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->boolean('active')->default(false);

            $table->foreignId('parent_id')->nullable()->references('id')->on('categories')->onDelete('set null');

            $table->string('category_name', 255)->unique();

            $table->text('category_description')->nullable();

//            $table->text('icon')->nullable();
//
//            $table->text('image')->nullable();

            $table->text('placeholder')->nullable();

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
        Schema::dropIfExists('categories');
    }
};
