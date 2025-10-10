<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Exam Routine User Table Migration - Version 1
 *
 * This migration creates the exam_routine_user table for the College Management System.
 * It handles exam routine user relationships with proper indexing and constraints.
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
        Schema::create('exam_routine_user', function (Blueprint $table) {
            $table->foreignId('exam_routine_id')->constrained('exam_routines')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->primary(['exam_routine_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_routine_user');
    }
};
