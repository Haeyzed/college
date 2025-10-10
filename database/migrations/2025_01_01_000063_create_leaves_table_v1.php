<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Leaves Table Migration - Version 1
 *
 * This migration creates the leaves table for the College Management System.
 * It handles leave information storage with proper indexing and constraints.
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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('review_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('apply_date');
            $table->date('from_date');
            $table->date('to_date');
            $table->text('reason')->nullable();
            $table->text('attach')->nullable();
            $table->text('note')->nullable();
            $table->string('pay_type')->default('paid');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['type_id']);
            $table->index(['from_date', 'to_date']);
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
        Schema::dropIfExists('leaves');
    }
};
