<?php

use App\Enums\v1\Status;
use App\Enums\v1\SubjectType;
use App\Enums\v1\ClassType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Subjects Table Migration - Version 1
 *
 * This migration creates the subjects table for the College Management System.
 * It handles subject information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('credit_hours');
            $table->string('subject_type')->default(SubjectType::COMPULSORY->value); // compulsory, optional, elective
            $table->string('class_type')->default(ClassType::THEORY->value); // theory, practical, both
            $table->decimal('total_marks', 5, 2)->nullable();
            $table->decimal('passing_marks', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->string('prerequisites')->nullable();
            $table->string('status')->default(Status::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['status', 'subject_type']);
            $table->index(['subject_type', 'class_type']);
            $table->index(['code']);
            $table->index(['credit_hours']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
