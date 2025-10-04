<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AssignmentRequest;
use App\Http\Requests\v1\SubmitAssignmentRequest;
use App\Http\Requests\v1\GradeAssignmentRequest;
use App\Http\Resources\v1\AssignmentResource;
use App\Http\Resources\v1\StudentAssignmentResource;
use App\Services\v1\AssignmentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AssignmentController - Version 1
 *
 * Controller for managing assignments in the College Management System.
 * This controller handles assignment-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AssignmentController extends Controller
{
    /**
     * The assignment service instance.
     *
     * @var AssignmentService
     */
    protected $assignmentService;

    /**
     * Create a new controller instance.
     *
     * @param AssignmentService $assignmentService
     */
    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Display a listing of assignments.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int, to: int}}
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->assignmentService->getAssignments($request);
            return response()->paginated(
                AssignmentResource::collection($result),
                'Assignments retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve assignments: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Store a newly created assignment.
     *
     * @param AssignmentRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource}
     */
    public function store(AssignmentRequest $request): JsonResponse
    {
        try {
            $result = $this->assignmentService->createAssignment($request->validated());
            return response()->created(
                new AssignmentResource($result),
                'Assignment created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to create assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Display the specified assignment.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource}
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->assignmentService->getAssignment($id);
            return response()->success(
                new AssignmentResource($result),
                'Assignment retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment not found');
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Update the specified assignment.
     *
     * @param AssignmentRequest $request
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource}
     */
    public function update(AssignmentRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->assignmentService->updateAssignment($request->validated(), $id);
            return response()->success(
                new AssignmentResource($result),
                'Assignment updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment not found');
        } catch (Exception $e) {
            return response()->internalServerError('Failed to update assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Remove the specified assignment.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string}
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->assignmentService->deleteAssignment($id);
            return response()->success([], 'Assignment deleted successfully');
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment not found');
        } catch (Exception $e) {
            return response()->badRequest('Failed to delete assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Get assignments for a specific student.
     *
     * @param Request $request
     * @param int $studentId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int, to: int}}
     */
    public function getStudentAssignments(Request $request, int $studentId): JsonResponse
    {
        try {
            $result = $this->assignmentService->getStudentAssignments($request, $studentId);
            return response()->paginated(
                AssignmentResource::collection($result),
                'Student assignments retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve student assignments: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Get assignments for a specific subject.
     *
     * @param Request $request
     * @param int $subjectId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int, to: int}}
     */
    public function getSubjectAssignments(Request $request, int $subjectId): JsonResponse
    {
        try {
            $result = $this->assignmentService->getSubjectAssignments($request, $subjectId);
            return response()->paginated(
                AssignmentResource::collection($result),
                'Subject assignments retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve subject assignments: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Get assignments for a specific teacher.
     *
     * @param Request $request
     * @param int $teacherId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: AssignmentResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int, to: int}}
     */
    public function getTeacherAssignments(Request $request, int $teacherId): JsonResponse
    {
        try {
            $result = $this->assignmentService->getTeacherAssignments($request, $teacherId);
            return response()->paginated(
                AssignmentResource::collection($result),
                'Teacher assignments retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError('Failed to retrieve teacher assignments: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Submit assignment for a student.
     *
     * @param SubmitAssignmentRequest $request
     * @param int $assignmentId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: StudentAssignmentResource}
     */
    public function submitAssignment(SubmitAssignmentRequest $request, int $assignmentId): JsonResponse
    {
        try {
            $result = $this->assignmentService->submitAssignment($request->validated(), $assignmentId);
            return response()->success(
                new StudentAssignmentResource($result),
                'Assignment submitted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment not found');
        } catch (Exception $e) {
            return response()->badRequest('Failed to submit assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Grade assignment for a student.
     *
     * @param GradeAssignmentRequest $request
     * @param int $assignmentId
     * @param int $studentId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: StudentAssignmentResource}
     */
    public function gradeAssignment(GradeAssignmentRequest $request, int $assignmentId, int $studentId): JsonResponse
    {
        try {
            $result = $this->assignmentService->gradeAssignment($request->validated(), $assignmentId, $studentId);
            return response()->success(
                new StudentAssignmentResource($result),
                'Assignment graded successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment or student assignment not found');
        } catch (Exception $e) {
            return response()->badRequest('Failed to grade assignment: ' . $e->getMessage(), $e->getMessage());
        }
    }

    /**
     * Get assignment statistics.
     *
     * @param int $assignmentId
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array{total_students: int, submitted: int, graded: int, pending: int, submission_rate: float, grading_rate: float}}
     */
    public function getStatistics(int $assignmentId): JsonResponse
    {
        try {
            $result = $this->assignmentService->getAssignmentStatistics($assignmentId);
            return response()->success(
                $result,
                'Assignment statistics retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Assignment not found');
        } catch (Exception $e) {
            return response()->internalServerError('Failed to get assignment statistics: ' . $e->getMessage(), $e->getMessage());
        }
    }
}