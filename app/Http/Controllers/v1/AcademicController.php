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
use App\Http\Requests\v1\EnrollSubjectRequest;
use App\Http\Resources\v1\FacultyResource;
use App\Http\Resources\v1\ProgramResource;
use App\Http\Resources\v1\BatchResource;
use App\Http\Resources\v1\SectionResource;
use App\Http\Resources\v1\SemesterResource;
use App\Http\Resources\v1\SubjectResource;
use App\Http\Resources\v1\AcademicSessionResource;
use App\Http\Resources\v1\ClassRoomResource;
use App\Http\Resources\v1\EnrollSubjectResource;
use App\Services\v1\AcademicService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AcademicController - Version 1
 *
 * Controller for managing academic operations in the College Management System.
 * This controller handles faculties, programs, batches, sections, semesters,
 * subjects, academic sessions, and classrooms.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AcademicController extends Controller
{
    /**
     * The academic service instance.
     *
     * @var AcademicService
     */
    protected AcademicService $academicService;

    /**
     * Create a new controller instance.
     *
     * @param AcademicService $academicService
     */
    public function __construct(AcademicService $academicService)
    {
        $this->academicService = $academicService;
    }

    /*
    |--------------------------------------------------------------------------
    | Faculty Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all faculty-related HTTP endpoints including CRUD operations
    | for faculties and faculty filtering. Faculty management endpoints include creating,
    | updating, deleting, and retrieving faculty information with support for
    | pagination, searching, status filtering, and bulk operations.
    |
    */

    /**
     * Get all faculties with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated faculty data
     * @response array{success: bool, message: string, data: FacultyResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getFaculties(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $search = $request->query('search');
            $status = $request->query('status');

            $result = $this->academicService->getFaculties($perPage, $search, $status);

            return response()->paginated(
                FacultyResource::collection($result),
                'Faculties retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve faculties: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific faculty by ID.
     *
     * @param int $id Faculty ID
     * @return JsonResponse JSON response with faculty data
     * @response array{success: bool, message: string, data: FacultyResource}
     */
    public function getFaculty(int $id): JsonResponse
    {
        try {
            $faculty = $this->academicService->getFacultyById($id);

            return response()->success(
                new FacultyResource($faculty),
                'Faculty retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Faculty not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve faculty: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new faculty.
     *
     * @param FacultyRequest $request Validated faculty creation request
     * @return JsonResponse JSON response with created faculty data
     * @response array{success: bool, message: string, data: FacultyResource}
     */
    public function createFaculty(FacultyRequest $request): JsonResponse
    {
        try {
            $faculty = $this->academicService->createFaculty($request->validated());

            return response()->success(
                new FacultyResource($faculty),
                'Faculty created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create faculty: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing faculty.
     *
     * @param FacultyRequest $request Validated faculty update request
     * @param int $id Faculty ID to update
     * @return JsonResponse JSON response with updated faculty data
     * @response array{success: bool, message: string, data: FacultyResource}
     */
    public function updateFaculty(FacultyRequest $request, int $id): JsonResponse
    {
        try {
            $faculty = $this->academicService->updateFaculty($id, $request->validated());

            return response()->success(
                new FacultyResource($faculty),
                'Faculty updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Faculty not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update faculty: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a faculty (Soft Delete).
     *
     * @param int $id Faculty ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteFaculty(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteFaculty($id);

            return response()->success(
                null,
                'Faculty soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Faculty not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete faculty: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update faculty status.
     *
     * @param Request $request HTTP request containing faculty IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateFacultyStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:faculties,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateFacultyStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} faculties"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update faculty status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete faculties (Soft Delete).
     *
     * @param Request $request HTTP request containing faculty IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteFaculties(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:faculties,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteFaculties($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} faculties"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete faculties: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Program Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all program-related HTTP endpoints including CRUD operations
    | for programs and program filtering. Program management endpoints include creating,
    | updating, deleting, and retrieving program information with support for
    | faculty association, degree type filtering, pagination, and bulk operations.
    |
    */

    /**
     * Get all programs with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated program data
     * @response array{success: bool, message: string, data: ProgramResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getPrograms(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $facultyId = $request->query('faculty_id');
            $status = $request->query('status');
            $search = $request->query('search');
            $degreeType = $request->query('degree_type');

            $result = $this->academicService->getPrograms($perPage, $facultyId, $status, $search, $degreeType);

            return response()->paginated(
                ProgramResource::collection($result),
                'Programs retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve programs: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific program by ID.
     *
     * @param int $id Program ID
     * @return JsonResponse JSON response with program data
     * @response array{success: bool, message: string, data: ProgramResource}
     */
    public function getProgram(int $id): JsonResponse
    {
        try {
            $program = $this->academicService->getProgramById($id);

            return response()->success(
                new ProgramResource($program),
                'Program retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Program not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve program: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new program.
     *
     * @param ProgramRequest $request Validated program creation request
     * @return JsonResponse JSON response with created program data
     * @response array{success: bool, message: string, data: ProgramResource}
     */
    public function createProgram(ProgramRequest $request): JsonResponse
    {
        try {
            $program = $this->academicService->createProgram($request->validated());

            return response()->success(
                new ProgramResource($program),
                'Program created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create program: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing program.
     *
     * @param ProgramRequest $request Validated program update request
     * @param int $id Program ID to update
     * @return JsonResponse JSON response with updated program data
     * @response array{success: bool, message: string, data: ProgramResource}
     */
    public function updateProgram(ProgramRequest $request, int $id): JsonResponse
    {
        try {
            $program = $this->academicService->updateProgram($id, $request->validated());

            return response()->success(
                new ProgramResource($program),
                'Program updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Program not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update program: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a program (Soft Delete).
     *
     * @param int $id Program ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteProgram(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteProgram($id);

            return response()->success(
                null,
                'Program soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Program not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete program: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update program status.
     *
     * @param Request $request HTTP request containing program IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateProgramStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:programs,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateProgramStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} programs"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update program status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete programs (Soft Delete).
     *
     * @param Request $request HTTP request containing program IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeletePrograms(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:programs,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeletePrograms($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} programs"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete programs: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Batch Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all batch-related HTTP endpoints including CRUD operations
    | for batches and batch filtering. Batch management endpoints include creating,
    | updating, deleting, and retrieving batch information with support for
    | program associations, academic year filtering, pagination, and bulk operations.
    |
    */

    /**
     * Get all batches with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated batch data
     * @response array{success: bool, message: string, data: BatchResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getBatches(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');
            $academicYear = $request->query('academic_year');

            $result = $this->academicService->getBatches($perPage, $status, $search, $academicYear);

            return response()->paginated(
                BatchResource::collection($result),
                'Batches retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve batches: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific batch by ID.
     *
     * @param int $id Batch ID
     * @return JsonResponse JSON response with batch data
     * @response array{success: bool, message: string, data: BatchResource}
     */
    public function getBatch(int $id): JsonResponse
    {
        try {
            $batch = $this->academicService->getBatchById($id);

            return response()->success(
                new BatchResource($batch),
                'Batch retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Batch not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve batch: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new batch.
     *
     * @param BatchRequest $request Validated batch creation request
     * @return JsonResponse JSON response with created batch data
     * @response array{success: bool, message: string, data: BatchResource}
     */
    public function createBatch(BatchRequest $request): JsonResponse
    {
        try {
            $batch = $this->academicService->createBatch($request->validated());

            return response()->success(
                new BatchResource($batch),
                'Batch created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create batch: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing batch.
     *
     * @param BatchRequest $request Validated batch update request
     * @param int $id Batch ID to update
     * @return JsonResponse JSON response with updated batch data
     * @response array{success: bool, message: string, data: BatchResource}
     */
    public function updateBatch(BatchRequest $request, int $id): JsonResponse
    {
        try {
            $batch = $this->academicService->updateBatch($id, $request->validated());

            return response()->success(
                new BatchResource($batch),
                'Batch updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Batch not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update batch: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a batch (Soft Delete).
     *
     * @param int $id Batch ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteBatch(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteBatch($id);

            return response()->success(
                null,
                'Batch soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Batch not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete batch: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update batch status.
     *
     * @param Request $request HTTP request containing batch IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateBatchStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:batches,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateBatchStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} batches"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update batch status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete batches (Soft Delete).
     *
     * @param Request $request HTTP request containing batch IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteBatches(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:batches,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteBatches($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} batches"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete batches: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Section Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all section-related HTTP endpoints including CRUD operations
    | for sections and section filtering. Section management endpoints include creating,
    | updating, deleting, and retrieving section information with support for
    | complex many-to-many relationships, batch filtering, pagination, and bulk operations.
    |
    */

    /**
     * Get all sections with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated section data
     * @response array{success: bool, message: string, data: SectionResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getSections(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $batchId = $request->query('batch_id');
            $status = $request->query('status');
            $search = $request->query('search');

            $result = $this->academicService->getSections($perPage, $batchId, $status, $search);

            return response()->paginated(
                SectionResource::collection($result),
                'Sections retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve sections: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific section by ID.
     *
     * @param int $id Section ID
     * @return JsonResponse JSON response with section data
     * @response array{success: bool, message: string, data: SectionResource}
     */
    public function getSection(int $id): JsonResponse
    {
        try {
            $section = $this->academicService->getSectionById($id);

            return response()->success(
                new SectionResource($section),
                'Section retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Section not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve section: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new section.
     *
     * @param SectionRequest $request Validated section creation request
     * @return JsonResponse JSON response with created section data
     * @response array{success: bool, message: string, data: SectionResource}
     */
    public function createSection(SectionRequest $request): JsonResponse
    {
        try {
            $section = $this->academicService->createSection($request->validated());

            return response()->success(
                new SectionResource($section),
                'Section created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create section: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing section.
     *
     * @param SectionRequest $request Validated section update request
     * @param int $id Section ID to update
     * @return JsonResponse JSON response with updated section data
     * @response array{success: bool, message: string, data: SectionResource}
     */
    public function updateSection(SectionRequest $request, int $id): JsonResponse
    {
        try {
            $section = $this->academicService->updateSection($id, $request->validated());

            return response()->success(
                new SectionResource($section),
                'Section updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Section not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update section: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a section (Soft Delete).
     *
     * @param int $id Section ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteSection(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteSection($id);

            return response()->success(
                null,
                'Section soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Section not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete section: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update section status.
     *
     * @param Request $request HTTP request containing section IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateSectionStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:sections,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateSectionStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} sections"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update section status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete sections (Soft Delete).
     *
     * @param Request $request HTTP request containing section IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteSections(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:sections,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteSections($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} sections"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete sections: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Semester Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all semester-related HTTP endpoints including CRUD operations
    | for semesters and semester filtering. Semester management endpoints include creating,
    | updating, deleting, and retrieving semester information with support for
    | program associations, academic year filtering, current semester tracking,
    | pagination, and bulk operations.
    |
    */

    /**
     * Get all semesters with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated semester data
     * @response array{success: bool, message: string, data: SemesterResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getSemesters(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');
            $academicYear = $request->query('academic_year');
            $isCurrent = $request->query('is_current');

            $isCurrentBool = $isCurrent === 'true' ? true : ($isCurrent === 'false' ? false : null);

            $result = $this->academicService->getSemesters($perPage, $status, $search, $academicYear, $isCurrentBool);

            return response()->paginated(
                SemesterResource::collection($result),
                'Semesters retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve semesters: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific semester by ID.
     *
     * @param int $id Semester ID
     * @return JsonResponse JSON response with semester data
     * @response array{success: bool, message: string, data: SemesterResource}
     */
    public function getSemester(int $id): JsonResponse
    {
        try {
            $semester = $this->academicService->getSemesterById($id);

            return response()->success(
                new SemesterResource($semester),
                'Semester retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Semester not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve semester: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new semester.
     *
     * @param SemesterRequest $request Validated semester creation request
     * @return JsonResponse JSON response with created semester data
     * @response array{success: bool, message: string, data: SemesterResource}
     */
    public function createSemester(SemesterRequest $request): JsonResponse
    {
        try {
            $semester = $this->academicService->createSemester($request->validated());

            return response()->success(
                new SemesterResource($semester),
                'Semester created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create semester: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing semester.
     *
     * @param SemesterRequest $request Validated semester update request
     * @param int $id Semester ID to update
     * @return JsonResponse JSON response with updated semester data
     * @response array{success: bool, message: string, data: SemesterResource}
     */
    public function updateSemester(SemesterRequest $request, int $id): JsonResponse
    {
        try {
            $semester = $this->academicService->updateSemester($id, $request->validated());

            return response()->success(
                new SemesterResource($semester),
                'Semester updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Semester not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update semester: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a semester (Soft Delete).
     *
     * @param int $id Semester ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteSemester(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteSemester($id);

            return response()->success(
                null,
                'Semester soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Semester not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete semester: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update semester status.
     *
     * @param Request $request HTTP request containing semester IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateSemesterStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:semesters,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateSemesterStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} semesters"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update semester status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete semesters (Soft Delete).
     *
     * @param Request $request HTTP request containing semester IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteSemesters(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:semesters,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteSemesters($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} semesters"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete semesters: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Subject Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all subject-related HTTP endpoints including CRUD operations
    | for subjects and subject filtering. Subject management endpoints include creating,
    | updating, deleting, and retrieving subject information with support for
    | program associations, faculty filtering, subject type classification,
    | credit hours management, pagination, and bulk operations.
    |
    */

    /**
     * Get all subjects with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated subject data
     * @response array{success: bool, message: string, data: SubjectResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getSubjects(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');
            $programId = $request->query('program_id');
            $facultyId = $request->query('faculty_id');
            $subjectType = $request->query('subject_type');
            $classType = $request->query('class_type');
            $creditHours = $request->query('credit_hours');

            $result = $this->academicService->getSubjects($perPage, $facultyId, $programId, $status, $search, $subjectType, $classType, $creditHours);

            return response()->paginated(
                SubjectResource::collection($result),
                'Subjects retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve subjects: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific subject by ID.
     *
     * @param int $id Subject ID
     * @return JsonResponse JSON response with subject data
     * @response array{success: bool, message: string, data: SubjectResource}
     */
    public function getSubject(int $id): JsonResponse
    {
        try {
            $subject = $this->academicService->getSubjectById($id);

            return response()->success(
                new SubjectResource($subject),
                'Subject retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new subject.
     *
     * @param SubjectRequest $request Validated subject creation request
     * @return JsonResponse JSON response with created subject data
     * @response array{success: bool, message: string, data: SubjectResource}
     */
    public function createSubject(SubjectRequest $request): JsonResponse
    {
        try {
            $subject = $this->academicService->createSubject($request->validated());

            return response()->success(
                new SubjectResource($subject),
                'Subject created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing subject.
     *
     * @param SubjectRequest $request Validated subject update request
     * @param int $id Subject ID to update
     * @return JsonResponse JSON response with updated subject data
     * @response array{success: bool, message: string, data: SubjectResource}
     */
    public function updateSubject(SubjectRequest $request, int $id): JsonResponse
    {
        try {
            $subject = $this->academicService->updateSubject($id, $request->validated());

            return response()->success(
                new SubjectResource($subject),
                'Subject updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a subject (Soft Delete).
     *
     * @param int $id Subject ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteSubject(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteSubject($id);

            return response()->success(
                null,
                'Subject soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update subject status.
     *
     * @param Request $request HTTP request containing subject IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateSubjectStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:subjects,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateSubjectStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} subjects"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update subject status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete subjects (Soft Delete).
     *
     * @param Request $request HTTP request containing subject IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteSubjects(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:subjects,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteSubjects($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} subjects"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete subjects: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Academic Session Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all academic session-related HTTP endpoints including CRUD operations
    | for academic sessions and academic session filtering. Academic session management
    | endpoints include creating, updating, deleting, and retrieving session information
    | with support for program associations, current session tracking, pagination,
    | and bulk operations.
    |
    */

    /**
     * Get all academic sessions with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated academic session data
     * @response array{success: bool, message: string, data: AcademicSessionResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getAcademicSessions(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');
            $isCurrent = $request->query('is_current');

            $isCurrentBool = $isCurrent === 'true' ? true : ($isCurrent === 'false' ? false : null);

            $result = $this->academicService->getAcademicSessions($perPage, $status, $search, $isCurrentBool);

            return response()->paginated(
                AcademicSessionResource::collection($result),
                'Academic sessions retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve academic sessions: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific academic session by ID.
     *
     * @param int $id Academic session ID
     * @return JsonResponse JSON response with academic session data
     * @response array{success: bool, message: string, data: AcademicSessionResource}
     */
    public function getAcademicSession(int $id): JsonResponse
    {
        try {
            $academicSession = $this->academicService->getAcademicSessionById($id);

            return response()->success(
                new AcademicSessionResource($academicSession),
                'Academic session retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Academic session not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve academic session: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new academic session.
     *
     * @param AcademicSessionRequest $request Validated academic session creation request
     * @return JsonResponse JSON response with created academic session data
     * @response array{success: bool, message: string, data: AcademicSessionResource}
     */
    public function createAcademicSession(AcademicSessionRequest $request): JsonResponse
    {
        try {
            $academicSession = $this->academicService->createAcademicSession($request->validated());

            return response()->success(
                new AcademicSessionResource($academicSession),
                'Academic session created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create academic session: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing academic session.
     *
     * @param AcademicSessionRequest $request Validated academic session update request
     * @param int $id Academic session ID to update
     * @return JsonResponse JSON response with updated academic session data
     * @response array{success: bool, message: string, data: AcademicSessionResource}
     */
    public function updateAcademicSession(AcademicSessionRequest $request, int $id): JsonResponse
    {
        try {
            $academicSession = $this->academicService->updateAcademicSession($id, $request->validated());

            return response()->success(
                new AcademicSessionResource($academicSession),
                'Academic session updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Academic session not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update academic session: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete an academic session (Soft Delete).
     *
     * @param int $id Academic session ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteAcademicSession(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteAcademicSession($id);

            return response()->success(
                null,
                'Academic session soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Academic session not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete academic session: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update academic session status.
     *
     * @param Request $request HTTP request containing academic session IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateAcademicSessionStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:academic_sessions,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateAcademicSessionStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} academic sessions"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update academic session status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete academic sessions (Soft Delete).
     *
     * @param Request $request HTTP request containing academic session IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteAcademicSessions(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:academic_sessions,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteAcademicSessions($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} academic sessions"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete academic sessions: ' . $e->getMessage()
            );
        }
    }

    /**
     * Set a specific academic session as the current session.
     *
     * @param int $id The ID of the session to set as current
     * @return JsonResponse JSON response with updated academic session data
     * @response array{success: bool, message: string, data: AcademicSessionResource}
     */
    public function setCurrentAcademicSession(int $id): JsonResponse
    {
        try {
            $session = $this->academicService->setCurrentAcademicSession($id);

            return response()->success(
                new AcademicSessionResource($session),
                'Academic session set as current successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Academic session not found.');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to set academic session as current: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ClassRoom Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all classroom-related HTTP endpoints including CRUD operations
    | for classrooms and classroom filtering. Classroom management endpoints include creating,
    | updating, deleting, and retrieving classroom information with support for
    | program associations, room type classification, availability tracking,
    | capacity management, pagination, and bulk operations.
    |
    */

    /**
     * Get all classrooms with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated classroom data
     * @response array{success: bool, message: string, data: ClassRoomResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getClassRooms(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');
            $roomType = $request->query('room_type');
            $isAvailable = $request->query('is_available');

            $isAvailableBool = $isAvailable === 'true' ? true : ($isAvailable === 'false' ? false : null);

            $result = $this->academicService->getClassRooms($perPage, $status, $search, $roomType, $isAvailableBool);

            return response()->paginated(
                ClassRoomResource::collection($result),
                'Classrooms retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve classrooms: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific classroom by ID.
     *
     * @param int $id Classroom ID
     * @return JsonResponse JSON response with classroom data
     * @response array{success: bool, message: string, data: ClassRoomResource}
     */
    public function getClassRoom(int $id): JsonResponse
    {
        try {
            $classRoom = $this->academicService->getClassRoomById($id);

            return response()->success(
                new ClassRoomResource($classRoom),
                'Classroom retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Classroom not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve classroom: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new classroom.
     *
     * @param ClassRoomRequest $request Validated classroom creation request
     * @return JsonResponse JSON response with created classroom data
     * @response array{success: bool, message: string, data: ClassRoomResource}
     */
    public function createClassRoom(ClassRoomRequest $request): JsonResponse
    {
        try {
            $classRoom = $this->academicService->createClassRoom($request->validated());

            return response()->created(
                new ClassRoomResource($classRoom),
                'Classroom created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create classroom: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing classroom.
     *
     * @param ClassRoomRequest $request Validated classroom update request
     * @param int $id Classroom ID to update
     * @return JsonResponse JSON response with updated classroom data
     * @response array{success: bool, message: string, data: ClassRoomResource}
     */
    public function updateClassRoom(ClassRoomRequest $request, int $id): JsonResponse
    {
        try {
            $classRoom = $this->academicService->updateClassRoom($id, $request->validated());

            return response()->success(
                new ClassRoomResource($classRoom),
                'Classroom updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Classroom not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update classroom: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a classroom (Soft Delete).
     *
     * @param int $id Classroom ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteClassRoom(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteClassRoom($id);

            return response()->success(
                null,
                'Classroom soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Classroom not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete classroom: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update classroom status.
     *
     * @param Request $request HTTP request containing classroom IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateClassRoomStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:class_rooms,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateClassRoomStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} classrooms"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update classroom status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete classrooms (Soft Delete).
     *
     * @param Request $request HTTP request containing classroom IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteClassRooms(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:class_rooms,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteClassRooms($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} classrooms"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete classrooms: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Enroll Subject Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all enroll subject-related HTTP endpoints including CRUD operations
    | for enroll subjects and enroll subject filtering. Enroll subject management
    | endpoints include creating, updating, deleting, and retrieving enrollment information
    | with support for program, semester, and section associations, comprehensive
    | subject enrollment tracking, pagination, and bulk operations.
    |
    */

    /**
     * Get all enroll subjects with filtering, searching, and pagination.
     *
     * @param Request $request HTTP request containing query parameters
     * @return JsonResponse JSON response with paginated enroll subject data
     * @response array{success: bool, message: string, data: EnrollSubjectResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getEnrollSubjects(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $programId = $request->query('program_id');
            $semesterId = $request->query('semester_id');
            $sectionId = $request->query('section_id');
            $status = $request->query('status');
            $search = $request->query('search');

            $result = $this->academicService->getEnrollSubjects($perPage, $programId, $semesterId, $sectionId, $status, $search);

            return response()->paginated(
                EnrollSubjectResource::collection($result),
                'Enroll subjects retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve enroll subjects: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific enroll subject by ID.
     *
     * @param int $id Enroll subject ID
     * @return JsonResponse JSON response with enroll subject data
     * @response array{success: bool, message: string, data: EnrollSubjectResource}
     */
    public function getEnrollSubject(int $id): JsonResponse
    {
        try {
            $enrollSubject = $this->academicService->getEnrollSubjectById($id);

            return response()->success(
                new EnrollSubjectResource($enrollSubject),
                'Enroll subject retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Enroll subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve enroll subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new enroll subject.
     *
     * @param EnrollSubjectRequest $request Validated enroll subject creation request
     * @return JsonResponse JSON response with created enroll subject data
     * @response array{success: bool, message: string, data: EnrollSubjectResource}
     */
    public function createEnrollSubject(EnrollSubjectRequest $request): JsonResponse
    {
        try {
            $enrollSubject = $this->academicService->createEnrollSubject($request->validated());

            return response()->success(
                new EnrollSubjectResource($enrollSubject),
                'Enroll subject created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create enroll subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing enroll subject.
     *
     * @param EnrollSubjectRequest $request Validated enroll subject update request
     * @param int $id Enroll subject ID to update
     * @return JsonResponse JSON response with updated enroll subject data
     * @response array{success: bool, message: string, data: EnrollSubjectResource}
     */
    public function updateEnrollSubject(EnrollSubjectRequest $request, int $id): JsonResponse
    {
        try {
            $enrollSubject = $this->academicService->updateEnrollSubject($id, $request->validated());

            return response()->success(
                new EnrollSubjectResource($enrollSubject),
                'Enroll subject updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Enroll subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update enroll subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete an enroll subject (Soft Delete).
     *
     * @param int $id Enroll subject ID to delete
     * @return JsonResponse JSON response confirming deletion
     * @response array{success: bool, message: string}
     */
    public function deleteEnrollSubject(int $id): JsonResponse
    {
        try {
            $this->academicService->deleteEnrollSubject($id);

            return response()->success(
                null,
                'Enroll subject soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Enroll subject not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete enroll subject: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update enroll subject status.
     *
     * @param Request $request HTTP request containing enroll subject IDs and new status
     * @return JsonResponse JSON response with update count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateEnrollSubjectStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:enroll_subjects,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->academicService->bulkUpdateEnrollSubjectStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} enroll subjects"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update enroll subject status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete enroll subjects (Soft Delete).
     *
     * @param Request $request HTTP request containing enroll subject IDs to delete
     * @return JsonResponse JSON response with deletion count
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteEnrollSubjects(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:enroll_subjects,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->academicService->bulkDeleteEnrollSubjects($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} enroll subjects"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete enroll subjects: ' . $e->getMessage()
            );
        }
    }
}
