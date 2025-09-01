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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // Changed from account_id to user_id
            $table->string('title', 100)->nullable();
            $table->text('content')->nullable();
            $table->boolean('seen')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('receive_time')->nullable();
            $table->date('notification_expiry_date')->nullable();
            // Removed timestamps as per schema for 'created_at' and 'receive_time' are explicitly defined.
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
