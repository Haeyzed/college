<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Items Table Migration - Version 1
 * 
 * This migration creates the items table for the College Management System.
 * It handles item information storage with proper indexing and constraints.
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('item_categories')->cascadeOnDelete();
            $table->string('unit')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('quantity')->default(0);
            $table->longText('description')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->index(['category_id']);
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
        Schema::dropIfExists('items');
    }
};
