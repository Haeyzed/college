<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Students Table Migration - Version 1
 *
 * This migration creates the students table for the College Management System.
 * It handles student information storage with proper indexing and constraints.
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('registration_no')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->date('admission_date')->nullable();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('father_photo')->nullable();
            $table->text('mother_photo')->nullable();

            // Authentication
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('password_text')->nullable();

            // Address Information
            $table->string('country')->nullable();
            $table->foreignId('present_province')->nullable()->references('id')->on('provinces')->nullOnDelete();
            $table->foreignId('present_district')->nullable()->references('id')->on('districts')->nullOnDelete();
            $table->text('present_village')->nullable();
            $table->text('present_address')->nullable();
            $table->foreignId('permanent_province')->nullable()->references('id')->on('provinces')->nullOnDelete();
            $table->foreignId('permanent_district')->nullable()->references('id')->on('districts')->nullOnDelete();
            $table->text('permanent_village')->nullable();
            $table->text('permanent_address')->nullable();

            // Personal Details
            $table->tinyInteger('gender')->comment('1 Male, 2 Female & 3 Other');
            $table->date('dob');
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();

            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->tinyInteger('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();

            // Education Information
            $table->text('school_name')->nullable();
            $table->string('school_exam_id')->nullable();
            $table->string('school_graduation_field')->nullable();
            $table->integer('school_graduation_year')->nullable();
            $table->decimal('school_graduation_point', 5, 2)->nullable();
            $table->string('school_transcript')->nullable();
            $table->string('school_certificate')->nullable();
            $table->text('collage_name')->nullable();
            $table->string('collage_exam_id')->nullable();
            $table->string('collage_graduation_field')->nullable();
            $table->integer('collage_graduation_year')->nullable();
            $table->decimal('collage_graduation_point', 5, 2)->nullable();
            $table->string('collage_transcript')->nullable();
            $table->string('collage_certificate')->nullable();

            // Documents
            $table->text('photo')->nullable();
            $table->text('signature')->nullable();

            // Status Information
            $table->boolean('login')->default(true);
            $table->tinyInteger('status')->default(1)->comment('0 Inactive, 1 Active, 2 Passed Out, 3 Transfer Out');
            $table->boolean('is_transfer')->default(false)->comment('0 Not Transfer, 1 Transfer In');

            $table->rememberToken();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('batch_id');
            $table->index('program_id');
            $table->index('admission_date');
            $table->index('created_at');
            $table->index('is_transfer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
