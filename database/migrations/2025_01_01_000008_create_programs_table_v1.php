<?php

use App\Enums\v1\Status;
use App\Enums\v1\DegreeType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Programs Table Migration - Version 1
 * 
 * This migration creates the programs table for the College Management System.
 * It handles program information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('duration_years');
            $table->integer('total_credits');
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->string('degree_type')->default(DegreeType::BACHELOR->value); // bachelor, master, phd, diploma, certificate
            $table->string('admission_requirements')->nullable();
            $table->boolean('is_registration_open')->default(true);
            $table->string('status')->default(Status::ACTIVE->value);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['faculty_id', 'status']);
            $table->index(['status', 'is_registration_open']);
            $table->index(['degree_type']);
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
        Schema::dropIfExists('programs');
    }
};
