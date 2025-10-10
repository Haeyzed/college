<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ApplicationRequest;
use App\Http\Resources\v1\ApplicationResource;
use App\Services\v1\AdmissionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AdmissionController - Version 1
 *
 * Controller for managing admission operations in the College Management System.
 * This controller handles applications and admission-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AdmissionController extends Controller
{
    /**
     * The admission service instance.
     *
     * @var AdmissionService
     */
    protected AdmissionService $admissionService;

    /**
     * Create a new controller instance.
     *
     * @param AdmissionService $admissionService
     */
    public function __construct(AdmissionService $admissionService)
    {
        $this->admissionService = $admissionService;
    }

    /*
    |--------------------------------------------------------------------------
    | Application Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all application-related HTTP endpoints including CRUD operations
    | for applications, application search, and application filtering by status, program,
    | and batch. Application management endpoints include creating, updating, deleting,
    | and retrieving application information with support for file handling, status tracking,
    | pagination, and bulk operations.
    |
    */

    /**
     * Get all applications with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated application data
     * @response array{success: bool, message: string, data: ApplicationResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getApplications(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $batchId = $request->query('batch_id');
            $programId = $request->query('program_id');
            $status = $request->query('status');
            $payStatus = $request->query('pay_status');
            $search = $request->query('search');
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            $result = $this->admissionService->getApplications($perPage, $batchId, $programId, $status, $payStatus, $search, $startDate, $endDate);

            return response()->paginated(
                ApplicationResource::collection($result),
                'Applications retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve applications: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific application by ID.
     *
     * @param int $id Application ID
     * @return JsonResponse JSON response with application data
     * @response array{success: bool, message: string, data: ApplicationResource}
     */
    public function getApplication(int $id): JsonResponse
    {
        try {
            $application = $this->admissionService->getApplicationById($id);

            return response()->success(
                new ApplicationResource($application),
                'Application retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Application not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve application: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new application.
     *
     * @requestMediaType multipart/form-data
     * @param ApplicationRequest $request Validated application creation request with file upload support
     * @return JsonResponse JSON response with created application data
     * @response array{success: bool, message: string, data: ApplicationResource}
     */
    public function createApplication(ApplicationRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file uploads
            $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'collage_transcript', 'collage_certificate'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $validatedData[$field] = $request->file($field);
                }
            }

            $application = $this->admissionService->createApplication($validatedData);

            return response()->success(
                new ApplicationResource($application),
                'Application created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create application: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing application.
     *
     * @requestMediaType multipart/form-data
     * @param ApplicationRequest $request Validated application update request with file upload support
     * @param int $id Application ID to update
     * @return JsonResponse JSON response with updated application data
     * @response array{success: bool, message: string, data: ApplicationResource}
     */
    public function updateApplication(ApplicationRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file uploads
            $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'collage_transcript', 'collage_certificate'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $validatedData[$field] = $request->file($field);
                }
            }

            $application = $this->admissionService->updateApplication($id, $validatedData);

            return response()->success(
                new ApplicationResource($application),
                'Application updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Application not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update application: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete an application.
     *
     * @param int $id Application ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteApplication(int $id): JsonResponse
    {
        try {
            $this->admissionService->deleteApplication($id);

            return response()->success(
                null,
                'Application deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Application not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to delete application: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update application status.
     *
     * @param Request $request HTTP request containing application IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateApplicationStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:applications,id',
                'status' => 'required|string|in:pending,in_progress,approved,rejected,admitted'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->admissionService->bulkUpdateApplicationStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} applications"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update application status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete applications.
     *
     * @param Request $request HTTP request containing application IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteApplications(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:applications,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->admissionService->bulkDeleteApplications($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully deleted {$deletedCount} applications"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk delete applications: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get application statistics.
     *
     * @return JsonResponse JSON response with application statistics
     * @response array{success: bool, message: string, data: array}
     */
    public function getApplicationStatistics(): JsonResponse
    {
        try {
            $statistics = $this->admissionService->getApplicationStatistics();

            return response()->success(
                $statistics,
                'Application statistics retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve application statistics: ' . $e->getMessage()
            );
        }
    }

}
