<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SmsSettingRequest;
use App\Http\Resources\v1\SmsSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * SmsSettingsController - Version 1
 *
 * Controller for managing SMS settings in the College Management System.
 * This controller handles SMS setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SmsSettingsController extends Controller
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
     * Display a listing of SMS settings.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array, meta: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getSmsSetting();
            return response()->success(
                new SmsSettingResource($result),
                'SMS setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve SMS setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the SMS setting.
     *
     * @param SmsSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(SmsSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateSmsSetting($request->validated());
            return response()->success(
                new SmsSettingResource($result),
                'SMS setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update SMS setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
