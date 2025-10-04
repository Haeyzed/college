<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create About Us Table Migration - Version 1
 * 
 * This migration creates the about_us table for the College Management System.
 * It handles about us information storage with proper indexing and constraints.
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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->string('title')->nullable();
            $table->text('short_desc')->nullable();
            $table->longText('description')->nullable();
            $table->longText('features')->nullable();
            $table->text('attach')->nullable();
            $table->string('video_id')->nullable();
            $table->string('button_text')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_desc')->nullable();
            $table->string('mission_icon')->nullable();
            $table->text('mission_image')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_desc')->nullable();
            $table->string('vision_icon')->nullable();
            $table->text('vision_image')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->index(['language_id', 'status']);
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
        Schema::dropIfExists('about_us');
    }
};
