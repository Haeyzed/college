<?php

use Illuminate\Support\Facades\Route;

/**
 * College Management System API Routes
 *
 * Main API routes file that includes versioned API routes.
 * This file serves as the entry point for all API routes.
 *
 * @package Routes\Api
 * @version 1.0.0
 * @author Softmax Technologies
 */

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'College Management System API is running',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString(),
    ]);
});

// Version 1 API Routes
require_once __DIR__ . '/api/v1.php';

// Default fallback route
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found',
        'status' => 'error',
        'code' => 404,
    ], 404);
});
