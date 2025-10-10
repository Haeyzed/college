<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create ID Card Settings Table Migration - Version 1
 *
 * This migration creates the id_card_settings table for the College Management System.
 * It handles ID card settings information storage with proper indexing and constraints.
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
        Schema::create('id_card_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->text('logo')->nullable();
            $table->text('background')->nullable();
            $table->string('website_url')->nullable();
            $table->string('validity')->nullable();
            $table->text('address')->nullable();
            $table->string('prefix')->nullable();
            $table->boolean('student_photo')->default(false);
            $table->boolean('signature')->default(false);
            $table->boolean('barcode')->default(false);
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
        Schema::dropIfExists('id_card_settings');
    }
};
