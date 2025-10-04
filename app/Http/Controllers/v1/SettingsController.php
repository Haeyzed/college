<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ApplicationSettingRequest;
use App\Http\Requests\v1\MailSettingRequest;
use App\Http\Requests\v1\SmsSettingRequest;
use App\Http\Requests\v1\SocialSettingRequest;
use App\Http\Requests\v1\SystemSettingRequest;
use App\Http\Resources\v1\ApplicationSettingResource;
use App\Http\Resources\v1\MailSettingResource;
use App\Http\Resources\v1\SmsSettingResource;
use App\Http\Resources\v1\SocialSettingResource;
use App\Http\Resources\v1\SystemSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * SettingsController - Version 1
 *
 * Controller for managing system settings in the College Management System.
 * This controller handles all settings-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SettingsController extends Controller
{
    /**
     * The settings service instance.
     *
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * Create a new controller instance.
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Get system settings.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getSystemSettings(): JsonResponse
    {
        try {
            $result = $this->settingsService->getSystemSettings();
            return response()->success(
                $result,
                'System settings retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('System settings not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve system settings: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update system settings.
     *
     * @param SystemSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function updateSystemSettings(SystemSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateSystemSettings($request->validated());
            return response()->success(
                $result,
                'System settings updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('System settings not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update system settings: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Get settings statistics.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $result = $this->settingsService->getSettingsStatistics();
            return response()->success(
                $result,
                'Settings statistics retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve settings statistics: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
