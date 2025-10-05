<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MailSettingRequest;
use App\Http\Resources\v1\MailSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * MailSettingsController - Version 1
 *
 * Controller for managing mail settings in the College Management System.
 * This controller handles mail setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class MailSettingsController extends Controller
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
     * Display the mail setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: MailSettingResource}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getMailSetting();
            return response()->success(
                new MailSettingResource($result),
                'Mail setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve mail setting: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update or create the mail setting.
     *
     * @param MailSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: MailSettingResource}
     */
    public function update(MailSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateMailSetting($request->validated());
            return response()->success(
                new MailSettingResource($result),
                'Mail setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update mail setting: ' . $e->getMessage()
            );
        }
    }
}
