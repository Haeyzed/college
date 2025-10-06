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
    */

    /**
     * Get all faculties with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param FacultyRequest $request
     * @return JsonResponse
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
     * @param FacultyRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all programs with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param ProgramRequest $request
     * @return JsonResponse
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
     * @param ProgramRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all batches with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param BatchRequest $request
     * @return JsonResponse
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
     * @param BatchRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all sections with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param SectionRequest $request
     * @return JsonResponse
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
     * @param SectionRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all semesters with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param SemesterRequest $request
     * @return JsonResponse
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
     * @param SemesterRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all subjects with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param SubjectRequest $request
     * @return JsonResponse
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
     * @param SubjectRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
    */

    /**
     * Get all academic sessions with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param AcademicSessionRequest $request
     * @return JsonResponse
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
     * @param AcademicSessionRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id The ID of the session to set as current.
     * @return JsonResponse
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
    */

    /**
     * Get all classrooms with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param ClassRoomRequest $request
     * @return JsonResponse
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
     * @param ClassRoomRequest $request
     * @param int $id
     * @return JsonResponse
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
     * @param int $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
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
}
