<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Exam Types Table Migration - Version 1
 *
 * This migration creates the exam_types table for the College Management System.
 * It handles exam type information storage with proper indexing and constraints.
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
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('marks', 5, 2);
            $table->decimal('contribution', 5, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

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
        Schema::dropIfExists('exam_types');
    }
};
