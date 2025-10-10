<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Subjects Table Migration - Version 1
 *
 * This migration creates the subjects table for the College Management System.
 * It handles subject information storage with proper indexing and constraints.
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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('code')->unique();
            $table->integer('credit_hour');
            $table->tinyInteger('subject_type')->default(1)->comment('0 Optional & 1 Compulsory');
            $table->tinyInteger('class_type')->default(1)->comment('1 Theory, 2 Practical & 3 Both');
            $table->decimal('total_marks', 5, 2)->nullable();
            $table->decimal('passing_marks', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('code');
            $table->index('subject_type');
            $table->index('class_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
