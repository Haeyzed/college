<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Call To Actions Table Migration - Version 1
 *
 * This migration creates the call_to_actions table for the College Management System.
 * It handles call to action information storage with proper indexing and constraints.
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
        Schema::create('call_to_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('image')->nullable();
            $table->text('bg_image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('video_id')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['language_id', 'status']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('call_to_actions');
    }
};
