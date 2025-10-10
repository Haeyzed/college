<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Tax Settings Table Migration - Version 1
 *
 * This migration creates the tax_settings table for the College Management System.
 * It handles tax settings information storage with proper indexing and constraints.
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
        Schema::create('tax_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 10, 2);
            $table->decimal('max_amount', 10, 2);
            $table->decimal('percentange', 4, 2);
            $table->decimal('max_no_taxable_amount', 10, 2)->default(0.00);
            $table->string('status')->default('active');
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
        Schema::dropIfExists('tax_settings');
    }
};
