<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Certificates Table Migration - Version 1
 *
 * This migration creates the certificates table for the College Management System.
 * It handles certificate information storage with proper indexing and constraints.
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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('certificate_templates')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('serial_no')->nullable();
            $table->date('date');
            $table->string('starting_year')->nullable();
            $table->string('ending_year')->nullable();
            $table->decimal('credits', 5, 2);
            $table->decimal('point', 5, 2);
            $table->string('barcode')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['template_id', 'student_id']);
            $table->index(['serial_no']);
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
        Schema::dropIfExists('certificates');
    }
};
