<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TaxSettingRequest;
use App\Http\Resources\v1\TaxSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TaxSettingsController - Version 1
 *
 * Controller for managing tax settings in the College Management System.
 * This controller handles tax setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class TaxSettingsController extends Controller
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
     * Display the tax setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getTaxSetting();
            return response()->success(
                new TaxSettingResource($result),
                'Tax setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve tax setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Update or create the tax setting.
     *
     * @param TaxSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function update(TaxSettingRequest $request): JsonResponse
    {
        try {
            $result = $this->settingsService->updateOrCreateTaxSetting($request->validated());
            return response()->success(
                new TaxSettingResource($result),
                'Tax setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update tax setting: ' . $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
