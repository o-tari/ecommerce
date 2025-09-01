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
        Schema::table('slideshows', function (Blueprint $table) {
            $table->text('image')->nullable()->change();
            $table->text('placeholder')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slideshows', function (Blueprint $table) {
            $table->text('image')->nullable(false)->change();
            $table->text('placeholder')->nullable(false)->change();
        });
    }
};
