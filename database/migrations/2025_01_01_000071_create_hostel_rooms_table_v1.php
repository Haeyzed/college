<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Hostel Rooms Table Migration - Version 1
 * 
 * This migration creates the hostel_rooms table for the College Management System.
 * It handles hostel room information storage with proper indexing and constraints.
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
        Schema::create('hostel_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('hostel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained('hostel_room_types')->cascadeOnDelete();
            $table->integer('bed')->default(1);
            $table->decimal('fee', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->index(['hostel_id', 'room_type_id']);
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
        Schema::dropIfExists('hostel_rooms');
    }
};
