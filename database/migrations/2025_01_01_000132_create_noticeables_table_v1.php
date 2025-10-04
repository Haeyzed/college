<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Noticeables Table Migration - Version 1
 * 
 * This migration creates the noticeables table for the College Management System.
 * It handles polymorphic notice relationships with proper indexing and constraints.
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
        Schema::create('noticeables', function (Blueprint $table) {
            $table->unsignedBigInteger('notice_id');
            $table->unsignedBigInteger('noticeable_id');
            $table->string('noticeable_type');
            
            $table->primary(['notice_id', 'noticeable_id', 'noticeable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('noticeables');
    }
};
