<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('library_settings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('library_name')->nullable();
            $table->string('library_code')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->decimal('fine_per_day', 8, 2)->nullable();
            $table->integer('max_books_per_student')->nullable();
            $table->integer('max_borrow_days')->nullable();
            $table->boolean('auto_approve_requests')->default(false);
            $table->boolean('require_approval')->default(true);
            $table->boolean('send_notifications')->default(true);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_settings');
    }
};
