<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TopbarSettingRequest;
use App\Http\Resources\v1\TopbarSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * TopbarSettingsController - Version 1
 *
 * Controller for managing topbar settings in the College Management System.
 * This controller handles topbar setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TopbarSettingsController extends Controller
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
     * Display the topbar setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getTopbarSetting();
            return response()->success(
                new TopbarSettingResource($result),
                'Topbar setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve topbar setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the topbar setting.
     *
     * @param TopbarSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(TopbarSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateTopbarSetting($request->validated());
            return response()->success(
                new TopbarSettingResource($result),
                'Topbar setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update topbar setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
