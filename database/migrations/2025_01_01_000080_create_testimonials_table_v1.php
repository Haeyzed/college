<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Testimonials Table Migration - Version 1
 *
 * This migration creates the testimonials table for the College Management System.
 * It handles testimonial information storage with proper indexing and constraints.
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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->text('description');
            $table->decimal('rating', 2, 2)->default(0.99);
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
        Schema::dropIfExists('testimonials');
    }
};
