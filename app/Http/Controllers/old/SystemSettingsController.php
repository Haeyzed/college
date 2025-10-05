<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SystemSettingRequest;
use App\Http\Resources\v1\SystemSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * SystemSettingsController - Version 1
 *
 * Controller for managing system settings in the College Management System.
 * This controller handles system setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SystemSettingsController extends Controller
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
     * Display the system setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getSystemSettings();
            return response()->success(
                new SystemSettingResource($result),
                'System setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve system setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the system setting.
     *
     * @param SystemSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(SystemSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateSystemSettings($request->validated());
            return response()->success(
                new SystemSettingResource($result),
                'System setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update system setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
