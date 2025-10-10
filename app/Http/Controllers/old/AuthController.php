<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ChangePasswordRequest;
use App\Http\Requests\v1\ForgotPasswordRequest;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Http\Requests\v1\ResetPasswordRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Authentication Controller - Version 1
 *
 * This controller handles authentication operations for the College Management System.
 * It provides endpoints for login, logout, registration, and user management.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AuthController extends Controller
{
    /**
     * Login user and create token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->error('Invalid credentials', 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 'Login successful');
        } catch (Exception $e) {
            return response()->internalError('Login failed', $e->getMessage());
        }
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->created([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 'Registration successful');
        } catch (Exception $e) {
            return response()->internalError('Registration failed', $e->getMessage());
        }
    }

    /**
     * Logout user and revoke token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->success(null, 'Logout successful');
        } catch (Exception $e) {
            return response()->internalError('Logout failed', $e->getMessage());
        }
    }

    /**
     * Get authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->success([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ], 'User retrieved successfully');
        } catch (Exception $e) {
            return response()->internalError('Failed to retrieve user', $e->getMessage());
        }
    }

    /**
     * Change user password.
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->error('Current password is incorrect', 400);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->success(null, 'Password changed successfully');
        } catch (Exception $e) {
            return response()->internalError('Failed to change password', $e->getMessage());
        }
    }

    /**
     * Refresh user token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Revoke current token
            $request->user()->currentAccessToken()->delete();

            // Create new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 'Token refreshed successfully');
        } catch (Exception $e) {
            return response()->internalError('Failed to refresh token', $e->getMessage());
        }
    }

    /**
     * Forgot password.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            // In a real implementation, you would send a password reset email
            // For now, we'll just return a success message
            return response()->success(null, 'Password reset instructions sent to your email');
        } catch (Exception $e) {
            return response()->internalError('Failed to process forgot password request', $e->getMessage());
        }
    }

    /**
     * Reset password.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            // In a real implementation, you would validate the reset token
            // For now, we'll just update the password
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->success(null, 'Password reset successfully');
        } catch (Exception $e) {
            return response()->internalError('Failed to reset password', $e->getMessage());
        }
    }
}
