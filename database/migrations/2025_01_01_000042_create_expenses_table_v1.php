<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Expenses Table Migration - Version 1
 *
 * This migration creates the expenses table for the College Management System.
 * It handles expense information storage with proper indexing and constraints.
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('expense_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('invoice_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('note')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index(['date']);
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
        Schema::dropIfExists('expenses');
    }
};
