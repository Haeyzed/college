<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create SMS Settings Table Migration - Version 1
 *
 * This migration creates the s_m_s_settings table for the College Management System.
 * It handles SMS settings information storage with proper indexing and constraints.
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
        Schema::create('s_m_s_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nexmo_key')->nullable();
            $table->string('nexmo_secret')->nullable();
            $table->string('nexmo_sender_name')->nullable();
            $table->string('twilio_sid')->nullable();
            $table->string('twilio_auth_token')->nullable();
            $table->string('twilio_number')->nullable();
            $table->string('status')->default('twilio');
            $table->timestamps();

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
        Schema::dropIfExists('s_m_s_settings');
    }
};
