<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Subject Markings Table Migration - Version 1
 *
 * This migration creates the subject_markings table for the College Management System.
 * It handles subject marking information storage with proper indexing and constraints.
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
        Schema::create('subject_markings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->decimal('exam_marks', 5, 2)->nullable();
            $table->decimal('attendances', 5, 2)->nullable();
            $table->decimal('assignments', 5, 2)->nullable();
            $table->decimal('activities', 5, 2)->nullable();
            $table->decimal('total_marks', 5, 2);
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['student_enroll_id', 'subject_id']);
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
        Schema::dropIfExists('subject_markings');
    }
};
