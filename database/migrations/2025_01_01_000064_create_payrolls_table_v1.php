<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Payrolls Table Migration - Version 1
 * 
 * This migration creates the payrolls table for the College Management System.
 * It handles payroll information storage with proper indexing and constraints.
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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('basic_salary', 10, 2)->default(0.00);
            $table->string('salary_type')->default('fixed');
            $table->decimal('total_earning', 10, 2);
            $table->decimal('total_allowance', 10, 2)->default(0.00);
            $table->decimal('bonus', 10, 2)->default(0.00);
            $table->decimal('total_deduction', 10, 2)->default(0.00);
            $table->decimal('gross_salary', 10, 2);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('net_salary', 10, 2);
            $table->date('salary_month');
            $table->date('pay_date')->nullable();
            $table->integer('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('unpaid');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['user_id', 'salary_month']);
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
        Schema::dropIfExists('payrolls');
    }
};
