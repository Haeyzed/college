<?php

use App\Enums\v1\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Faculties Table Migration - Version 1
 * 
 * This migration creates the faculties table for the College Management System.
 * It handles faculty information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('dean_name')->nullable();
            $table->string('dean_email')->nullable();
            $table->string('dean_phone')->nullable();
            $table->string('status')->default(Status::ACTIVE->value);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['status', 'sort_order']);
            $table->index(['slug']);
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
        Schema::dropIfExists('faculties');
    }
};
