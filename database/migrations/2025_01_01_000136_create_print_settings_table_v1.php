<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Print Settings Table Migration - Version 1
 *
 * This migration creates the print_settings table for the College Management System.
 * It handles print settings information storage with proper indexing and constraints.
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
        Schema::create('print_settings', function (Blueprint $table) {
            $table->id();
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
            $table->string('width')->default('auto');
            $table->string('height')->default('auto');
            $table->string('prefix')->nullable();
            $table->boolean('student_photo')->default(false);
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
        Schema::dropIfExists('print_settings');
    }
};
