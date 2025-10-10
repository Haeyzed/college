<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Fees Fines Table Migration - Version 1
 *
 * This migration creates the fees_fines table for the College Management System.
 * It handles fee fine information storage with proper indexing and constraints.
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
        Schema::create('fees_fines', function (Blueprint $table) {
            $table->id();
            $table->integer('start_day');
            $table->integer('end_day');
            $table->decimal('amount', 10, 2);
            $table->string('type')->default('fixed'); // fixed, percentage
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['start_day', 'end_day']);
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
        Schema::dropIfExists('fees_fines');
    }
};
