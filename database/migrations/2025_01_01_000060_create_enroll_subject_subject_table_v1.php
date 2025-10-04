<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Enroll Subject Subject Table Migration - Version 1
 * 
 * This migration creates the enroll_subject_subject table for the College Management System.
 * It handles enroll subject to subject relationships with proper indexing and constraints.
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
        Schema::create('enroll_subject_subject', function (Blueprint $table) {
            $table->foreignId('enroll_subject_id')->constrained('enroll_subjects')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            
            $table->primary(['enroll_subject_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('enroll_subject_subject');
    }
};
