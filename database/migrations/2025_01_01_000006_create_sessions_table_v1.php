<?php

use App\Enums\v1\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Academic Sessions Table Migration - Version 1
 * 
 * This migration creates the academic_sessions table for the College Management System.
 * It handles academic session information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('academic_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->string('status')->default(Status::ACTIVE->value);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['status', 'is_current']);
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
        Schema::dropIfExists('academic_sessions');
    }
};
