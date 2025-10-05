<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\FacultyRequest;
use App\Http\Requests\v1\ProgramRequest;
use App\Http\Requests\v1\BatchRequest;
use App\Http\Requests\v1\SectionRequest;
use App\Http\Requests\v1\SemesterRequest;
use App\Http\Requests\v1\SubjectRequest;
use App\Http\Requests\v1\AcademicSessionRequest;
use App\Http\Requests\v1\ClassRoomRequest;
use App\Http\Resources\v1\FacultyResource;
use App\Http\Resources\v1\ProgramResource;
use App\Http\Resources\v1\BatchResource;
use App\Http\Resources\v1\SectionResource;
use App\Http\Resources\v1\SemesterResource;
use App\Http\Resources\v1\SubjectResource;
use App\Http\Resources\v1\AcademicSessionResource;
use App\Http\Resources\v1\ClassRoomResource;
use App\Services\v1\AcademicService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AcademicController - Version 1
 *
 * Controller for managing academic operations in the College Management System.
 * This controller handles faculties, programs, batches, sections, semesters, subjects,
 * academic sessions, and classrooms API endpoints.
 *
 * @version 1.0.0
 *
 * @author Softmax Technologies
 */
class AcademicController extends Controller
{
    public function __construct(
        private readonly AcademicService $academicService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Faculty Endpoints
    |--------------------------------------------------------------------------
    |
    | These endpoints handle all faculty-related operations including CRUD operations
    | for faculties and faculty filtering.
    |
    */

    /**
     * Get a paginated list of faculties.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFaculties(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');
            $status = $request->get('status');

            $faculties = $this->academicService->getFaculties($perPage, $search, $status);

            return response()->json([
                'success' => true,
                'message' => 'Faculties retrieved successfully',
                'data' => FacultyResource::collection($faculties),
                'meta' => [
                    'current_page' => $faculties->currentPage(),
                    'last_page' => $faculties->lastPage(),
                    'per_page' => $faculties->perPage(),
                    'total' => $faculties->total(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve faculties',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific faculty by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getFaculty(int $id): JsonResponse
    {
        try {
            $faculty = $this->academicService->getFacultyById($id);

            return response()->json([
                'success' => true,
                'message' => 'Faculty retrieved successfully',
                'data' => new FacultyResource($faculty),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve faculty',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Create a new faculty.
     *
     * @param FacultyRequest $request
     * @return JsonResponse
     */
    public function createFaculty(FacultyRequest $request): JsonResponse
    {
        try {
            $faculty = $this->academicService->createFaculty($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Faculty created successfully',
                'data' => new FacultyResource($faculty),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create faculty',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a faculty.
     *
     * @param FacultyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateFaculty(FacultyRequest $request, int $id): JsonResponse
    {
        try {
            $faculty = $this->academicService->updateFaculty($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Faculty updated successfully',
                'data' => new FacultyResource($faculty),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update faculty',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a faculty (Soft Delete).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteFaculty(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteFaculty($id);

            return response()->json([
                'success' => true,
                'message' => 'Faculty deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete faculty',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk update faculty status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkUpdateFacultyStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:faculties,id',
                'status' => 'required|string|in:active,inactive',
            ]);

            $updatedCount = $this->academicService->bulkUpdateFacultyStatus(
                $request->get('ids'),
                $request->get('status')
            );

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} faculties",
                'updated_count' => $updatedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update faculty status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk delete faculties (Soft Delete).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDeleteFaculties(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:faculties,id',
            ]);

            $deletedCount = $this->academicService->bulkDeleteFaculties($request->get('ids'));

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} faculties",
                'deleted_count' => $deletedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete faculties',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Program Endpoints
    |--------------------------------------------------------------------------
    |
    | These endpoints handle all program-related operations including CRUD operations
    | for programs and program filtering.
    |
    */

    /**
     * Get a paginated list of programs.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPrograms(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $facultyId = $request->get('faculty_id');
            $status = $request->get('status');
            $search = $request->get('search');
            $degreeType = $request->get('degree_type');

            $programs = $this->academicService->getPrograms($perPage, $facultyId, $status, $search, $degreeType);

            return response()->json([
                'success' => true,
                'message' => 'Programs retrieved successfully',
                'data' => ProgramResource::collection($programs),
                'meta' => [
                    'current_page' => $programs->currentPage(),
                    'last_page' => $programs->lastPage(),
                    'per_page' => $programs->perPage(),
                    'total' => $programs->total(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve programs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific program by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getProgram(int $id): JsonResponse
    {
        try {
            $program = $this->academicService->getProgramById($id);

            return response()->json([
                'success' => true,
                'message' => 'Program retrieved successfully',
                'data' => new ProgramResource($program),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve program',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Create a new program.
     *
     * @param ProgramRequest $request
     * @return JsonResponse
     */
    public function createProgram(ProgramRequest $request): JsonResponse
    {
        try {
            $program = $this->academicService->createProgram($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Program created successfully',
                'data' => new ProgramResource($program),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create program',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a program.
     *
     * @param ProgramRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateProgram(ProgramRequest $request, int $id): JsonResponse
    {
        try {
            $program = $this->academicService->updateProgram($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Program updated successfully',
                'data' => new ProgramResource($program),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update program',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a program (Soft Delete).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteProgram(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteProgram($id);

            return response()->json([
                'success' => true,
                'message' => 'Program deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete program',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk update program status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkUpdateProgramStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:programs,id',
                'status' => 'required|string|in:active,inactive',
            ]);

            $updatedCount = $this->academicService->bulkUpdateProgramStatus(
                $request->get('ids'),
                $request->get('status')
            );

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} programs",
                'updated_count' => $updatedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update program status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk delete programs (Soft Delete).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDeletePrograms(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:programs,id',
            ]);

            $deletedCount = $this->academicService->bulkDeletePrograms($request->get('ids'));

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} programs",
                'deleted_count' => $deletedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete programs',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Batch Endpoints
    |--------------------------------------------------------------------------
    |
    | These endpoints handle all batch-related operations including CRUD operations
    | for batches and batch filtering.
    |
    */

    /**
     * Get a paginated list of batches.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBatches(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $programId = $request->get('program_id');
            $status = $request->get('status');
            $search = $request->get('search');
            $academicYear = $request->get('academic_year');

            $batches = $this->academicService->getBatches($perPage, $programId, $status, $search, $academicYear);

            return response()->json([
                'success' => true,
                'message' => 'Batches retrieved successfully',
                'data' => BatchResource::collection($batches),
                'meta' => [
                    'current_page' => $batches->currentPage(),
                    'last_page' => $batches->lastPage(),
                    'per_page' => $batches->perPage(),
                    'total' => $batches->total(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve batches',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific batch by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getBatch(int $id): JsonResponse
    {
        try {
            $batch = $this->academicService->getBatchById($id);

            return response()->json([
                'success' => true,
                'message' => 'Batch retrieved successfully',
                'data' => new BatchResource($batch),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve batch',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Create a new batch.
     *
     * @param BatchRequest $request
     * @return JsonResponse
     */
    public function createBatch(BatchRequest $request): JsonResponse
    {
        try {
            $batch = $this->academicService->createBatch($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Batch created successfully',
                'data' => new BatchResource($batch),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create batch',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a batch.
     *
     * @param BatchRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateBatch(BatchRequest $request, int $id): JsonResponse
    {
        try {
            $batch = $this->academicService->updateBatch($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Batch updated successfully',
                'data' => new BatchResource($batch),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update batch',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a batch (Soft Delete).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deleteBatch(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteBatch($id);

            return response()->json([
                'success' => true,
                'message' => 'Batch deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete batch',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk update batch status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkUpdateBatchStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:batches,id',
                'status' => 'required|string|in:active,inactive',
            ]);

            $updatedCount = $this->academicService->bulkUpdateBatchStatus(
                $request->get('ids'),
                $request->get('status')
            );

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} batches",
                'updated_count' => $updatedCount,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update batch status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk delete batches (Soft Delete).
     *
     