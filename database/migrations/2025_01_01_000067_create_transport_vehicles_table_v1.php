<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Transport Vehicles Table Migration - Version 1
 *
 * This migration creates the transport_vehicles table for the College Management System.
 * It handles transport vehicle information storage with proper indexing and constraints.
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
        Schema::create('transport_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
            $table->string('year_made')->nullable();
            $table->string('driver_name')->nullable();
            $table->text('driver_license')->nullable();
            $table->text('driver_contact')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['type', 'status']);
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
        Schema::dropIfExists('transport_vehicles');
    }
};
