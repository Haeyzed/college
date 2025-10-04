<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ScheduleSettingRequest;
use App\Http\Resources\v1\ScheduleSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ScheduleSettingsController - Version 1
 *
 * Controller for managing schedule settings in the College Management System.
 * This controller handles schedule setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ScheduleSettingsController extends Controller
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
     * Display the schedule setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getScheduleSetting();
            return response()->success(
                new ScheduleSettingResource($result),
                'Schedule setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve schedule setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the schedule setting.
     *
     * @param ScheduleSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(ScheduleSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateScheduleSetting($request->validated());
            return response()->success(
                new ScheduleSettingResource($result),
                'Schedule setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update schedule setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
