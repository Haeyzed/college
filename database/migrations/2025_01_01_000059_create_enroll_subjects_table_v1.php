<?php

use App\Enums\v1\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Enroll Subjects Table Migration - Version 1
 *
 * This migration creates the enroll_subjects table for the College Management System.
 * It handles subject enrollment information storage with proper indexing and constraints.
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
        Schema::create('enroll_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default(Status::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['program_id', 'semester_id', 'section_id']);
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('enroll_subjects');
    }
};
