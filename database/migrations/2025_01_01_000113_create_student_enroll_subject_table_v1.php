<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Student Enroll Subject Table Migration - Version 1
 * 
 * This migration creates the student_enroll_subject table for the College Management System.
 * It handles student enrollment to subject relationships with proper indexing and constraints.
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
        Schema::create('student_enroll_subject', function (Blueprint $table) {
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            
            $table->primary(['student_enroll_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enroll_subject');
    }
};
