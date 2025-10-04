<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Exams Table Migration - Version 1
 * 
 * This migration creates the exams table for the College Management System.
 * It handles exam information storage with proper indexing and constraints.
 * 
 * @package Database\Migrations
 * @version 1.0.0
 * @author Softmax Technologies
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_type_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('attendance')->default('absent');
            $table->decimal('marks', 5, 2)->nullable();
            $table->decimal('achieve_marks', 5, 2)->nullable();
            $table->decimal('contribution', 5, 2)->default(0.00);
            $table->text('note')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['student_enroll_id', 'subject_id']);
            $table->index(['date', 'time']);
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
        Schema::dropIfExists('exams');
    }
};
