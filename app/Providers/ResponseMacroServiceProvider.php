<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * Response Macro Service Provider - Version 1
 *
 * This service provider registers custom response macros for the College Management System.
 * It provides standardized API response formats for consistent API documentation.
 *
 * @package App\Providers
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Success response macro
        Response::macro('success', function ($data = null, string $message = 'Success', int $statusCode = 200) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $statusCode);
        });

        // Error response macro
        Response::macro('error', function (string $message = 'Error', $errors = null, int $statusCode = 400) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], $statusCode);
        });

        // Created response macro
        Response::macro('created', function ($data = null, string $message = 'Resource created successfully', int $statusCode = 201) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $statusCode);
        });

        // Not found response macro
        Response::macro('notFound', function (string $message = 'Resource not found', int $statusCode = 404) {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });

        // Unauthorized response macro
        Response::macro('unauthorized', function (string $message = 'Unauthorized access', int $statusCode = 401) {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });

        // Forbidden response macro
        Response::macro('forbidden', function (string $message = 'Access forbidden', int $statusCode = 403) {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });

        // Validation error response macro
        Response::macro('validationError', function ($errors, string $message = 'Validation failed', int $statusCode = 422) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], $statusCode);
        });

        // Bad request response macro
        Response::macro('badRequest', function (string $message = 'Bad request', $errors = null, int $statusCode = 400) {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });

        // Internal server error response macro
        Response::macro('internalServerError', function (string $message = 'Internal server error', $error = null, int $statusCode = 500) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'error' => $error,
            ], $statusCode);
        });

        // Paginated response macro
        Response::macro('paginated', function ($data, string $message = 'Data retrieved successfully', int $statusCode = 200) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data->items(),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                    'from' => $data->firstItem(),
                    'to' => $data->lastItem(),
                ]
            ], $statusCode);
        });
    }
}
