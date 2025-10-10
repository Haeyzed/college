<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Postal Exchanges Table Migration - Version 1
 *
 * This migration creates the postal_exchanges table for the College Management System.
 * It handles postal exchange information storage with proper indexing and constraints.
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
        Schema::create('postal_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('category_id')->constrained('postal_exchange_types')->cascadeOnDelete();
            $table->string('title');
            $table->text('reference')->nullable();
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->text('note')->nullable();
            $table->date('date')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('on_hold');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['category_id']);
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
        Schema::dropIfExists('postal_exchanges');
    }
};
