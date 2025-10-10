<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Exam Routines Table Migration - Version 1
 *
 * This migration creates the exam_routines table for the College Management System.
 * It handles exam routine information storage with proper indexing and constraints.
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
        Schema::create('exam_routines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['exam_type_id', 'session_id']);
            $table->index(['program_id', 'semester_id', 'section_id']);
            $table->index(['date', 'start_time']);
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
        Schema::dropIfExists('exam_routines');
    }
};
