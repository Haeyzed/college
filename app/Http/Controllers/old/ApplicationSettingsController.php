<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ApplicationSettingRequest;
use App\Http\Resources\v1\ApplicationSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * ApplicationSettingsController - Version 1
 *
 * Controller for managing application settings in the College Management System.
 * This controller handles application setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationSettingsController extends Controller
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
     * Display the application setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getApplicationSetting();
            return response()->success(
                new ApplicationSettingResource($result),
                'Application setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve application setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the application setting.
     *
     * @param ApplicationSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(ApplicationSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateApplicationSetting($request->validated());
            return response()->success(
                new ApplicationSettingResource($result),
                'Application setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update application setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
