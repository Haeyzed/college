<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('password_text')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->date('joining_date')->nullable();
            $table->date('ending_date')->nullable();
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
            $table->string('graduation_academy')->nullable();
            $table->string('year_of_graduation')->nullable();
            $table->string('graduation_field')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('note')->nullable();
            $table->decimal('basic_salary', 10, 2)->default(0.00);
            $table->string('contract_type')->default('full_time');
            $table->foreignId('work_shift')->nullable()->constrained('work_shift_types')->nullOnDelete();
            $table->string('salary_type')->default('fixed');
            $table->text('epf_no')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('tin_no')->nullable();
            $table->text('photo')->nullable();
            $table->text('signature')->nullable();
            $table->text('resume')->nullable();
            $table->text('joining_letter')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('login')->default(true);
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['email']);
            $table->index(['status']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
