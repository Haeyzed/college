<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Applications Table Migration - Version 1
 *
 * This migration creates the applications table for the College Management System.
 * It handles application information storage with proper indexing and constraints.
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->date('apply_date')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('father_photo')->nullable();
            $table->text('mother_photo')->nullable();
            $table->string('country')->nullable();
            $table->foreignId('present_province')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('present_district')->nullable()->constrained('districts')->nullOnDelete();
            $table->text('present_village')->nullable();
            $table->text('present_address')->nullable();
            $table->foreignId('permanent_province')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('permanent_district')->nullable()->constrained('districts')->nullOnDelete();
            $table->text('permanent_village')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();
            $table->text('school_name')->nullable();
            $table->string('school_exam_id')->nullable();
            $table->string('school_graduation_field')->nullable();
            $table->string('school_graduation_year')->nullable();
            $table->string('school_graduation_point')->nullable();
            $table->string('school_transcript')->nullable();
            $table->string('school_certificate')->nullable();
            $table->text('college_name')->nullable();
            $table->string('college_exam_id')->nullable();
            $table->string('college_graduation_field')->nullable();
            $table->string('college_graduation_year')->nullable();
            $table->string('college_graduation_point')->nullable();
            $table->string('college_transcript')->nullable();
            $table->string('college_certificate')->nullable();
            $table->text('photo')->nullable();
            $table->text('signature')->nullable();
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->string('pay_status')->default('unpaid');
            $table->integer('payment_method')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['program_id', 'status']);
            $table->index(['registration_no']);
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
        Schema::dropIfExists('applications');
    }
};
