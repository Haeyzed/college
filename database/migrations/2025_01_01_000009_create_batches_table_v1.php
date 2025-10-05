<?php

use App\Enums\v1\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Batches Table Migration - Version 1
 * 
 * This migration creates the batches table for the College Management System.
 * It handles batch information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('academic_year');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_students')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(Status::ACTIVE->value);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['program_id', 'status']);
            $table->index(['academic_year']);
            $table->index(['start_date', 'end_date']);
            $table->index(['code']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
