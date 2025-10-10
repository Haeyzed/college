<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SocialSettingRequest;
use App\Http\Resources\v1\SocialSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * SocialSettingsController - Version 1
 *
 * Controller for managing social settings in the College Management System.
 * This controller handles social setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SocialSettingsController extends Controller
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
     * Display a listing of social settings.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array, meta: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getSocialSetting();
            return response()->success(
                new SocialSettingResource($result),
                'Social setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve social setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the social setting.
     *
     * @param SocialSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(SocialSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateSocialSetting($request->validated());
            return response()->success(
                new SocialSettingResource($result),
                'Social setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update social setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
