<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Outside Users Table Migration - Version 1
 *
 * This migration creates the outside_users table for the College Management System.
 * It handles outside user information storage with proper indexing and constraints.
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
        Schema::create('outside_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->text('father_photo')->nullable();
            $table->text('mother_photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->foreignId('present_province')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('present_district')->nullable()->constrained('districts')->nullOnDelete();
            $table->text('present_village')->nullable();
            $table->text('present_address')->nullable();
            $table->foreignId('permanent_province')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('permanent_district')->nullable()->constrained('districts')->nullOnDelete();
            $table->text('permanent_village')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('education_level')->nullable();
            $table->string('occupation')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->string('religion')->nullable();
            $table->string('caste')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();
            $table->text('photo')->nullable();
            $table->text('signature')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

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
        Schema::dropIfExists('outside_users');
    }
};
