<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreApplicationRequest;
use App\Http\Requests\v1\UpdateApplicationRequest;
use App\Http\Resources\v1\ApplicationResource;
use App\Services\v1\ApplicationService;
use App\Services\v1\StudentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Application Controller - Version 1
 *
 * This controller handles all application-related HTTP requests for the College Management System.
 * It provides endpoints for CRUD operations, approval/rejection, and statistics.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationController extends Controller
{

    /**
     * Application service instance.
     *
     * @var ApplicationService
     */
    protected ApplicationService $applicationService;

    /**
     * Student service instance.
     *
     * @var StudentService
     */
    protected StudentService $studentService;

    /**
     * Create a new controller instance.
     *
     * @param ApplicationService $applicationService
     * @param StudentService $studentService
     */
    public function __construct(
        ApplicationService $applicationService,
        StudentService     $studentService
    )
    {
        $this->applicationService = $applicationService;
        $this->studentService = $studentService;
    }

    /**
     * Display a paginated list of applications.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->applicationService->index($request);
            return response()->paginated(
                ApplicationResource::collection($result),
                'Applications retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve applications: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Store a newly created application.
     *
     * @param StoreApplicationRequest $request
     * @return JsonResponse
     */
    public function store(StoreApplicationRequest $request): JsonResponse
    {
        try {
            $result = $this->applicationService->store($request->validated());
            return response()->created(
                new ApplicationResource($result),
                'Application created successfully'
            );
        } catch (Exception $e) {
            return response()->error('Failed to create application: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Display the specified application.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->applicationService->show($id);
            return response()->success(
                new ApplicationResource($result),
                'Application retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->notFound('Application not found');
        }
    }

    /**
     * Update the specified application.
     *
     * @param UpdateApplicationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateApplicationRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->applicationService->update($request->validated(), $id);
            return response()->success(
                new ApplicationResource($result),
                'Application updated successfully'
            );
        } catch (Exception $e) {
            return response()->error('Failed to update application: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Remove the specified application.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->applicationService->destroy($id);
            return response()->success([], 'Application deleted successfully');
        } catch (Exception $e) {
            return response()->error('Failed to delete application: ' . $e->getMessage(), null, 400);
        }
    }

    /**
     * Approve the specified application.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function approve(Request $request, int $id): JsonResponse
    {
        try {
            $application = $this->applicationService->approveApplication($id, $request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Application approved successfully',
                'data' => new ApplicationResource($application->load([
                    'batch',
                    'program.faculty',
                    'presentProvince',
                    'presentDistrict',
                    'permanentProvince',
                    'permanentDistrict'
                ])),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Reject the specified application.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        try {
            $reason = $request->input('reason', '');
            $application = $this->applicationService->rejectApplication($id, $reason);

            return response()->json([
                'status' => 'success',
                'message' => 'Application rejected successfully',
                'data' => new ApplicationResource($application->load([
                    'batch',
                    'program.faculty',
                    'presentProvince',
                    'presentDistrict',
                    'permanentProvince',
                    'permanentDistrict'
                ])),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Convert application to student.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function convertToStudent(Request $request, int $id): JsonResponse
    {
        try {
            $additionalData = $request->validate([
                'password' => 'nullable|string|min:6',
                'admission_date' => 'nullable|date',
            ]);

            $student = $this->studentService->createStudentFromApplication($id, $additionalData);

            return response()->json([
                'status' => 'success',
                'message' => 'Application converted to student successfully',
                'data' => [
                    'student_id' => $student->id,
                    'student_code' => $student->student_id,
                    'email' => $student->email,
                    'name' => $student->first_name . ' ' . $student->last_name,
                ],
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get application statistics.
     *
     * @return JsonResponse
     */
    public function statistics(): JsonResponse
    {
        try {
            $statistics = $this->applicationService->getApplicationStatistics();

            return response()->json([
                'status' => 'success',
                'message' => 'Application statistics retrieved successfully',
                'data' => $statistics,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get dashboard overview data.
     *
     * @return JsonResponse
     */
    public function dashboardOverview(): JsonResponse
    {
        try {
            $applicationStats = $this->applicationService->getApplicationStatistics();
            $studentStats = $this->studentService->getStudentStatistics();

            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard overview retrieved successfully',
                'data' => [
                    'applications' => $applicationStats,
                    'students' => $studentStats,
                    'summary' => [
                        'total_applications' => $applicationStats['total'],
                        'pending_applications' => $applicationStats['pending'],
                        'total_students' => $studentStats['total'],
                        'active_students' => $studentStats['active'],
                    ],
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recent activities.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function recentActivities(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 10);

            $recentApplications = $this->applicationService->getApplications(
                $request->merge(['per_page' => $limit, 'sort_by' => 'created_at', 'sort_order' => 'desc'])
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Recent activities retrieved successfully',
                'data' => [
                    'recent_applications' => ApplicationResource::collection($recentApplications->items()),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get dashboard statistics.
     *
     * @return JsonResponse
     */
    public function dashboardStatistics(): JsonResponse
    {
        try {
            $applicationStats = $this->applicationService->getApplicationStatistics();
            $studentStats = $this->studentService->getStudentStatistics();

            return response()->json([
                'status' => 'success',
                'message' => 'Dashboard statistics retrieved successfully',
                'data' => [
                    'applications' => $applicationStats,
                    'students' => $studentStats,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
