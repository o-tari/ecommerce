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
        Schema::create('slideshows', function (Blueprint $table) {
            $table->id();
            $table->string('title', 80)->nullable();
            $table->text('destination_url')->nullable();
            $table->text('image');
            $table->text('placeholder');
            $table->string('description', 160)->nullable();
            $table->string('btn_label', 50)->nullable();
            $table->integer('display_order');
            $table->boolean('published')->default(false);
            $table->integer('clicks')->default(0);
            $table->jsonb('styles')->nullable();
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
        Schema::dropIfExists('slideshows');
    }
};
