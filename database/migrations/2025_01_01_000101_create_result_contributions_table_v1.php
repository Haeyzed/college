<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Result Contributions Table Migration - Version 1
 *
 * This migration creates the result_contributions table for the College Management System.
 * It handles result contribution information storage with proper indexing and constraints.
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
        Schema::create('result_contributions', function (Blueprint $table) {
            $table->id();
            $table->decimal('attendances', 5, 2)->default(0.00);
            $table->decimal('assignments', 5, 2)->default(0.00);
            $table->decimal('activities', 5, 2)->default(0.00);
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
        Schema::dropIfExists('result_contributions');
    }
};
