<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Fees Table Migration - Version 1
 * 
 * This migration creates the fees table for the College Management System.
 * It handles fee information storage with proper indexing and constraints.
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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_enroll_id')->constrained('student_enrolls')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('fees_categories')->cascadeOnDelete();
            $table->decimal('fee_amount', 10, 2);
            $table->decimal('fine_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('paid_amount', 10, 2);
            $table->date('assign_date');
            $table->date('due_date');
            $table->date('pay_date')->nullable();
            $table->integer('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('unpaid');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['student_enroll_id', 'status']);
            $table->index(['category_id']);
            $table->index(['due_date']);
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
        Schema::dropIfExists('fees');
    }
};
