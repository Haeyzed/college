<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\IdCardSettingRequest;
use App\Http\Resources\v1\IdCardSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * IdCardSettingsController - Version 1
 *
 * Controller for managing ID card settings in the College Management System.
 * This controller handles ID card setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class IdCardSettingsController extends Controller
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
     * Display the ID card setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getIdCardSetting();
            return response()->success(
                new IdCardSettingResource($result),
                'ID card setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve ID card setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the ID card setting.
     *
     * @param IdCardSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(IdCardSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateIdCardSetting($request->validated());
            return response()->success(
                new IdCardSettingResource($result),
                'ID card setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update ID card setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
