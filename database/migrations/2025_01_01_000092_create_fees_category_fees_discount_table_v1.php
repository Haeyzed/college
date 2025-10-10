<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Fees Category Fees Discount Table Migration - Version 1
 *
 * This migration creates the fees_category_fees_discount table for the College Management System.
 * It handles fees category to discount relationships with proper indexing and constraints.
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
        Schema::create('fees_category_fees_discount', function (Blueprint $table) {
            $table->foreignId('fees_category_id')->constrained('fees_categories')->cascadeOnDelete();
            $table->foreignId('fees_discount_id')->constrained('fees_discounts')->cascadeOnDelete();

            $table->primary(['fees_category_id', 'fees_discount_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_category_fees_discount');
    }
};
