<?php

use App\Enums\v1\Status;
use App\Enums\v1\RoomType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Class Rooms Table Migration - Version 1
 *
 * This migration creates the class_rooms table for the College Management System.
 * It handles classroom information storage with proper indexing, constraints, and soft deletes.
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
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('floor')->nullable();
            $table->integer('capacity');
            $table->string('room_type')->default(RoomType::CLASSROOM->value); // classroom, lab, library, auditorium, conference
            $table->text('description')->nullable();
            $table->json('facilities')->nullable(); // ["projector", "whiteboard", "air_conditioning"]
            $table->boolean('is_available')->default(true);
            $table->string('status')->default(Status::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['status', 'is_available']);
            $table->index(['room_type']);
            $table->index(['floor']);
            $table->index(['capacity']);
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
        Schema::dropIfExists('class_rooms');
    }
};
