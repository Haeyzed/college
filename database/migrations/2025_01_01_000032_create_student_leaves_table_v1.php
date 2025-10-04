<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Student Leaves Table Migration - Version 1
 * 
 * This migration creates the student_leaves table for the College Management System.
 * It handles student leave information storage with proper indexing and constraints.
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
        Schema::create('student_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('review_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('apply_date');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('subject')->nullable();
            $table->longText('reason')->nullable();
            $table->text('attach')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->index(['student_id', 'status']);
            $table->index(['status']);
            $table->index(['from_date', 'to_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('student_leaves');
    }
};
