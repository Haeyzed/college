<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Enquiries Table Migration - Version 1
 *
 * This migration creates the enquiries table for the College Management System.
 * It handles enquiry information storage with proper indexing and constraints.
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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reference_id')->nullable()->constrained('enquiry_references')->nullOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('enquiry_sources')->nullOnDelete();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('purpose')->nullable();
            $table->text('note')->nullable();
            $table->date('date');
            $table->date('follow_up_date')->nullable();
            $table->string('assigned')->nullable();
            $table->integer('number_of_students')->default(1);
            $table->string('status')->default('pending'); // pending, progress, resolved, closed
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['program_id', 'status']);
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
        Schema::dropIfExists('enquiries');
    }
};
