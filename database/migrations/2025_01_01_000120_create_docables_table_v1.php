<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Docables Table Migration - Version 1
 *
 * This migration creates the docables table for the College Management System.
 * It handles polymorphic document relationships with proper indexing and constraints.
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
        Schema::create('docables', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->string('docable_type');
            $table->unsignedBigInteger('docable_id');

            $table->primary(['document_id', 'docable_id', 'docable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('docables');
    }
};
