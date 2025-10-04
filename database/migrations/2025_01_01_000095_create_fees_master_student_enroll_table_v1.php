<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Fees Master Student Enroll Table Migration - Version 1
 * 
 * This migration creates the fees_master_student_enroll table for the College Management System.
 * It handles fees master to student enrollment relationships with proper indexing and constraints.
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
        Schema::create('fees_master_student_enroll', function (Blueprint $table) {
            $table->foreignId('fees_master_id')->constrained('fees_masters')->cascadeOnDelete();
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            
            $table->primary(['fees_master_id', 'student_enroll_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_master_student_enroll');
    }
};
