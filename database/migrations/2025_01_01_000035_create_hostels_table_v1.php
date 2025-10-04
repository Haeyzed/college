<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Hostels Table Migration - Version 1
 * 
 * This migration creates the hostels table for the College Management System.
 * It handles hostel information storage with proper indexing and constraints.
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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('boys'); // boys, girls, staff, combined
            $table->string('capacity')->nullable();
            $table->string('warden_name')->nullable();
            $table->text('warden_contact')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('hostels');
    }
};
