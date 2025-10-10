<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Programs Table Migration - Version 1
 *
 * This migration creates the programs table for the College Management System.
 * It handles academic program information storage with proper indexing and constraints.
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained()->cascadeOnDelete();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('shortcode')->nullable();
            $table->boolean('registration')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('slug');
            $table->index('faculty_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
