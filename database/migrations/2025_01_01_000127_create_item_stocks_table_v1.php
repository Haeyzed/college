<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Item Stocks Table Migration - Version 1
 *
 * This migration creates the item_stocks table for the College Management System.
 * It handles item stock information storage with proper indexing and constraints.
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
        Schema::create('item_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('item_suppliers')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('item_stores')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date');
            $table->string('reference')->nullable();
            $table->integer('payment_method')->nullable();
            $table->text('description')->nullable();
            $table->text('attach')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['item_id', 'store_id']);
            $table->index(['date']);
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
        Schema::dropIfExists('item_stocks');
    }
};
