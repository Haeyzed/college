<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Web Events Table Migration - Version 1
 *
 * This migration creates the web_events table for the College Management System.
 * It handles web event information storage with proper indexing and constraints.
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
        Schema::create('web_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('address')->nullable();
            $table->longText('description')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['language_id', 'status']);
            $table->index(['slug']);
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
        Schema::dropIfExists('web_events');
    }
};
