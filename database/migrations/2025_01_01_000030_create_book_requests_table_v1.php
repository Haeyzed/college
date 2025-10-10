<?php

use App\Enums\v1\BookRequestStatus;
use App\Models\v1\BookCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Book Requests Table Migration - Version 1
 *
 * This migration creates the book_requests table for the College Management System.
 * It handles book request information storage with proper indexing and constraints.
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
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BookCategory::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('isbn')->nullable();
            $table->string('accession_number', 50)->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->unsignedSmallInteger('publication_year')->nullable();
            $table->string('language')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('quantity')->default(1);

            $table->string('requester_name');
            $table->string('requester_phone')->nullable();
            $table->string('requester_email')->nullable();

            $table->longText('description')->nullable();
            $table->text('note')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('status')->default(BookRequestStatus::PENDING->value);
            $table->timestamps();

            // Soft Deletes
            $table->softDeletes();

            // --- INDEXING (Optimized) ---
            $table->index(['book_category_id', 'status']);
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
        Schema::dropIfExists('book_requests');
    }
};
