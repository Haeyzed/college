<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Fees Discount Status Type Table Migration - Version 1
 *
 * This migration creates the fees_discount_status_type table for the College Management System.
 * It handles fees discount to status type relationships with proper indexing and constraints.
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
        Schema::create('fees_discount_status_type', function (Blueprint $table) {
            $table->foreignId('fees_discount_id')->constrained('fees_discounts')->cascadeOnDelete();
            $table->foreignId('status_type_id')->constrained('status_types')->cascadeOnDelete();

            $table->primary(['fees_discount_id', 'status_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_discount_status_type');
    }
};
