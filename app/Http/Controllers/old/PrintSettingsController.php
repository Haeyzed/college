<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PrintSettingRequest;
use App\Http\Resources\v1\PrintSettingResource;
use App\Services\v1\SettingsService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * PrintSettingsController - Version 1
 *
 * Controller for managing print settings in the College Management System.
 * This controller handles print setting-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class PrintSettingsController extends Controller
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
     * Display the print setting.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: PrintSettingResource}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->settingsService->getPrintSetting();
            return response()->success(
                new PrintSettingResource($result),
                'Print setting retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve print setting: ' . $e->getMessage()
            );
        }
    }


    /**
     * Update or create the print setting.
     *
     * @requestMediaType multipart/form-data
     * @param PrintSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: PrintSettingResource}
     */
    public function update(PrintSettingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file uploads
            if ($request->hasFile('logo_left_file')) {
                $validatedData['logo_left_file'] = $request->file('logo_left_file');
            }

            if ($request->hasFile('logo_right_file')) {
                $validatedData['logo_right_file'] = $request->file('logo_right_file');
            }

            if ($request->hasFile('background_file')) {
                $validatedData['background_file'] = $request->file('background_file');
            }

            $result = $this->settingsService->updateOrCreatePrintSetting($validatedData);

            return response()->success(
                new PrintSettingResource($result),
                'Print setting updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update print setting: ' . $e->getMessage()
            );
        }
    }
}
