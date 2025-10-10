<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Application Settings Table Migration - Version 1
 *
 * This migration creates the application_settings table for the College Management System.
 * It handles application settings information storage with proper indexing and constraints.
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
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text('title')->nullable();
            $table->text('header_left')->nullable();
            $table->text('header_center')->nullable();
            $table->text('header_right')->nullable();
            $table->longText('body')->nullable();
            $table->text('footer_left')->nullable();
            $table->text('footer_center')->nullable();
            $table->text('footer_right')->nullable();
            $table->text('logo_left')->nullable();
            $table->text('logo_right')->nullable();
            $table->text('background')->nullable();
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->boolean('pay_online')->default(true);
            $table->string('status')->default('active');
            $table->timestamps();

            $table->index(['slug']);
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
        Schema::dropIfExists('application_settings');
    }
};
