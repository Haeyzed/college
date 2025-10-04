<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Transport Route Transport Vehicle Table Migration - Version 1
 * 
 * This migration creates the transport_route_transport_vehicle table for the College Management System.
 * It handles transport route to vehicle relationships with proper indexing and constraints.
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
        Schema::create('transport_route_transport_vehicle', function (Blueprint $table) {
            $table->foreignId('transport_route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->foreignId('transport_vehicle_id')->constrained('transport_vehicles')->cascadeOnDelete();
            
            $table->primary(['transport_route_id', 'transport_vehicle_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_route_transport_vehicle');
    }
};
