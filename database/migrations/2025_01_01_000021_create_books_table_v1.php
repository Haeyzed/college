<?php

use App\Enums\v1\Status;
use App\Models\v1\BookCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Books Table Migration - Version 2.0.0
 *
 * This migration creates the books table for the College Management System,
 * applying good naming conventions, soft deletes, and optimized indexing.
 *
 * @package Database\Migrations
 * @version 2.0.0
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BookCategory::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('isbn', 30)->unique()->nullable();
            $table->string('accession_number', 50)->nullable()->unique();
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->unsignedSmallInteger('publication_year')->nullable();
            $table->string('language', 50)->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->unsignedInteger('quantity')->default(0);
            $table->string('shelf_location', 50)->nullable();
            $table->string('shelf_column', 50)->nullable();
            $table->string('shelf_row', 50)->nullable();
            $table->longText('description')->nullable();
            $table->text('note')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('status', 20)->default(Status::ACTIVE->value);
            $table->timestamps();

            // Soft Deletes
            $table->softDeletes();

            // --- INDEXING (Optimized) ---
            $table->index('title');
            $table->index('author');
            $table->index('isbn');
            $table->index('accession_number');

            // Compound index for efficient common filtering queries (e.g., finding available books in a category)
            $table->index(['book_category_id', 'status', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
