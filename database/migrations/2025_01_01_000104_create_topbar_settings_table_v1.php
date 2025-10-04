<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Topbar Settings Table Migration - Version 1
 * 
 * This migration creates the topbar_settings table for the College Management System.
 * It handles topbar settings information storage with proper indexing and constraints.
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
        Schema::create('topbar_settings', function (Blueprint $table) {
            $table->id();
            $table->string('address_title')->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('working_hour')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_summary')->nullable();
            $table->string('social_title')->nullable();
            $table->string('social_status')->default('active');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('topbar_settings');
    }
};
