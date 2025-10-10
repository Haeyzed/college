<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Schedule Settings Table Migration - Version 1
 *
 * This migration creates the schedule_settings table for the College Management System.
 * It handles schedule settings information storage with proper indexing and constraints.
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
        Schema::create('schedule_settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('day');
            $table->time('time');
            $table->boolean('email')->default(false);
            $table->boolean('sms')->default(false);
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
        Schema::dropIfExists('schedule_settings');
    }
};
