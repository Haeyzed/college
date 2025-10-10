<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Sliders Table Migration - Version 1
 *
 * This migration creates the sliders table for the College Management System.
 * It handles slider information storage with proper indexing and constraints.
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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('sub_title')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->text('attach')->nullable();
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
        Schema::dropIfExists('sliders');
    }
};
