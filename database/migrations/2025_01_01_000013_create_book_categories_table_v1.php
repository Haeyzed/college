<?php

use App\Enums\v1\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Book Categories Table Migration - Version 2.0.0
 *
 * This migration creates the book_categories table, applying good naming conventions,
 * adding slug and code fields, soft deletes, and optimized indexing.
 *
 * @package Database\Migrations
 * @version 2.0.0
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
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('code', 20)->nullable()->unique();
            $table->longText('description')->nullable();
            $table->string('status', 20)->default(Status::ACTIVE->value);
            $table->timestamps();

            // Soft Deletes
            $table->softDeletes();

            // --- INDEXING (Optimized) ---
            $table->index('slug');
            $table->index('code');
            $table->index(['status', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('book_categories');
    }
};
