<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Notifications Table Migration - Version 1
 *
 * This migration creates the notifications table for the College Management System.
 * It handles notification information storage with proper indexing and constraints.
 *
 * @package Database\Migrations
 * @version 1.0.0
 * @author Softmax Technologies
 */
return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->morphs('notifiable'); // notifiable_type, notifiable_id
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['read_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
