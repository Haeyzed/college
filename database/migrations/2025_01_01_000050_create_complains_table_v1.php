<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Complains Table Migration - Version 1
 *
 * This migration creates the complains table for the College Management System.
 * It handles complain information storage with proper indexing and constraints.
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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('complain_types')->cascadeOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('complain_sources')->nullOnDelete();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('date');
            $table->text('action_taken')->nullable();
            $table->string('assigned')->nullable();
            $table->text('issue');
            $table->text('note')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('pending'); // pending, progress, resolved, rejected
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['type_id', 'status']);
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
        Schema::dropIfExists('complains');
    }
};
