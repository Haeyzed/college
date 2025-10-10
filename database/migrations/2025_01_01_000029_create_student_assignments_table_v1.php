<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Student Assignments Table Migration - Version 1
 *
 * This migration creates the student_assignments table for the College Management System.
 * It handles student assignment submission information storage with proper indexing and constraints.
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
        Schema::create('student_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->decimal('marks', 5, 2)->nullable();
            $table->string('attendance')->nullable();
            $table->date('date')->nullable();
            $table->text('attach')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['student_enroll_id', 'assignment_id']);
            $table->index(['assignment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assignments');
    }
};
