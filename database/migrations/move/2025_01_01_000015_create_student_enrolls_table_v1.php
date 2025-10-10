<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Student Enrolls Table Migration - Version 1
 *
 * This migration creates the student_enrolls table for the College Management System.
 * It handles student enrollment information storage with proper indexing and constraints.
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
        Schema::create('student_enrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('status')->default(1)->comment('0 Inactive, 1 Active');
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('student_id');
            $table->index('program_id');
            $table->index('session_id');
            $table->index('semester_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrolls');
    }
};
