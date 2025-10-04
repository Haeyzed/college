<?php

namespace App\Services\v1;

use App\Models\v1\Assignment;
use App\Models\v1\StudentAssignment;
use App\Models\v1\StudentEnroll;
use App\Models\v1\Student;
use App\Models\v1\User;
use App\Http\Resources\v1\AssignmentResource;
use App\Http\Resources\v1\StudentAssignmentResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

/**
 * AssignmentService - Version 1
 *
 * Service for managing assignments in the College Management System.
 * This service handles assignment business logic and data operations.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AssignmentService
{
    /*
    |--------------------------------------------------------------------------
    | Assignment Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all assignment-related operations including CRUD operations
    | for assignments, assignment search, and assignment filtering by various criteria.
    |
    */

    /**
     * Get a paginated list of assignments.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAssignments(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        // Prepare filters array for the scope
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'status', 
            'start_date', 'end_date', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])->filterBy($filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Create a new assignment.
     *
     * @param array $data
     * @return Assignment
     * @throws Exception
     */
    public function createAssignment(array $data): Assignment
    {
        return DB::transaction(function () use ($data) {
            // Set assignment data
            $assignmentData = [
                'faculty_id' => $data['faculty_id'],
                'program_id' => $data['program_id'],
                'session_id' => $data['session_id'],
                'semester_id' => $data['semester_id'],
                'section_id' => $data['section_id'],
                'subject_id' => $data['subject_id'],
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'total_marks' => $data['total_marks'],
                'start_date' => $data['start_date'] ?? Carbon::today(),
                'end_date' => $data['end_date'],
                'attach' => $data['attach'] ?? null,
                'assign_by' => $data['assign_by'] ?? Auth::id(),
                'status' => $data['status'] ?? 'active'
            ];

            $assignment = Assignment::create($assignmentData);

            // Get students for this assignment
            $students = $this->getStudentsForAssignment($data);
            
            // Create student assignments
            $this->createStudentAssignments($assignment->id, $students);

            // Send notifications to students
            $this->sendAssignmentNotifications($assignment, $students);

            Log::info('Assignment created successfully', [
                'assignment_id' => $assignment->id,
                'title' => $assignment->title,
                'students_count' => count($students)
            ]);

            return $assignment->load([
                'faculty:id,title',
                'program:id,title',
                'session:id,title',
                'semester:id,title',
                'section:id,title',
                'subject:id,title,code',
                'teacher:id,first_name,last_name'
            ]);
        }, 5);
    }

    /**
     * Get a specific assignment with details.
     *
     * @param int $id
     * @return Assignment
     */
    public function getAssignment(int $id): Assignment
    {
        return Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name',
            'students.student:id,first_name,last_name,student_id'
        ])->findOrFail($id);
    }

    /**
     * Update an assignment.
     *
     * @param array $data
     * @param int $id
     * @return Assignment
     * @throws Exception
     */
    public function updateAssignment(array $data, int $id): Assignment
    {
        return DB::transaction(function () use ($data, $id) {
            $assignment = Assignment::findOrFail($id);
            
            $updateData = array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'total_marks' => $data['total_marks'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'attach' => $data['attach'] ?? null,
                'status' => $data['status'] ?? null,
            ], fn($value) => $value !== null);

            $assignment->update($updateData);

            Log::info('Assignment updated successfully', [
                'assignment_id' => $assignment->id,
                'title' => $assignment->title
            ]);

            return $assignment->load([
                'faculty:id,title',
                'program:id,title',
                'session:id,title',
                'semester:id,title',
                'section:id,title',
                'subject:id,title,code',
                'teacher:id,first_name,last_name'
            ]);
        }, 5);
    }

    /**
     * Delete an assignment and related data.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteAssignment(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $assignment = Assignment::findOrFail($id);
            
            // Delete student assignments
            StudentAssignment::where('assignment_id', $id)->delete();
            
            // Delete notifications
            DB::table('notifications')
                ->where('type', 'App\Notifications\AssignmentNotification')
                ->where('data->id', $id)
                ->delete();
            
            // Delete assignment
            $assignment->delete();

            Log::info('Assignment deleted successfully', [
                'assignment_id' => $id
            ]);

            return true;
        }, 5);
    }

    /**
     * Get assignments for a specific student.
     *
     * @param Request $request
     * @param int $studentId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getStudentAssignments(Request $request, int $studentId): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        // Prepare filters array for the scope
        $filters = $request->only([
            'session_id', 'semester_id', 'subject_id', 'status', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->whereHas('students', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })
        ->filterBy($filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get assignments for a specific subject.
     *
     * @param Request $request
     * @param int $subjectId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getSubjectAssignments(Request $request, int $subjectId): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        // Prepare filters array for the scope
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 'status', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->filterBySubject($subjectId)
        ->filterBy($filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Submit assignment for a student.
     *
     * @param array $data
     * @param int $assignmentId
     * @return StudentAssignment
     * @throws Exception
     */
    public function submitAssignment(array $data, int $assignmentId): StudentAssignment
    {
        return DB::transaction(function () use ($data, $assignmentId) {
            $studentAssignment = StudentAssignment::updateOrCreate(
                [
                    'assignment_id' => $assignmentId,
                    'student_id' => $data['student_id'],
                ],
                [
                    'submission' => $data['submission'],
                    'attach' => $data['attach'] ?? null,
                    'status' => 'submitted',
                    'submitted_at' => now(),
                ]
            );

            Log::info('Assignment submitted successfully', [
                'assignment_id' => $assignmentId,
                'student_id' => $data['student_id']
            ]);

            return $studentAssignment->load('student:id,first_name,last_name,student_id');
        }, 5);
    }

    /**
     * Grade assignment for a student.
     *
     * @param array $data
     * @param int $assignmentId
     * @param int $studentId
     * @return StudentAssignment
     * @throws Exception
     */
    public function gradeAssignment(array $data, int $assignmentId, int $studentId): StudentAssignment
    {
        return DB::transaction(function () use ($data, $assignmentId, $studentId) {
            $studentAssignment = StudentAssignment::where('assignment_id', $assignmentId)
                ->where('student_id', $studentId)
                ->firstOrFail();

            $studentAssignment->update([
                'marks' => $data['marks'],
                'feedback' => $data['feedback'] ?? null,
                'status' => 'graded',
                'graded_at' => now(),
            ]);

            Log::info('Assignment graded successfully', [
                'assignment_id' => $assignmentId,
                'student_id' => $studentId,
                'marks' => $data['marks']
            ]);

            return $studentAssignment->load('student:id,first_name,last_name,student_id');
        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    |
    | These methods provide supporting functionality for assignment operations.
    |
    */

    /**
     * Get students for assignment based on criteria.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getStudentsForAssignment(array $data): \Illuminate\Database\Eloquent\Collection
    {
        $query = Student::where('status', 'active')
            ->with(['currentEnroll' => function($q) use ($data) {
                $q->where('program_id', $data['program_id'])
                  ->where('session_id', $data['session_id'])
                  ->where('semester_id', $data['semester_id'])
                  ->where('section_id', $data['section_id'])
                  ->where('status', 'active');
            }])
            ->whereHas('currentEnroll', function($q) use ($data) {
                $q->where('program_id', $data['program_id'])
                  ->where('session_id', $data['session_id'])
                  ->where('semester_id', $data['semester_id'])
                  ->where('section_id', $data['section_id'])
                  ->where('status', 'active');
            })
            ->whereHas('currentEnroll.subjects', function($q) use ($data) {
                $q->where('subject_id', $data['subject_id']);
            });

        if (isset($data['faculty_id']) && $data['faculty_id'] != 0) {
            $query->whereHas('program', function($q) use ($data) {
                $q->where('faculty_id', $data['faculty_id']);
            });
        }

        return $query->get();
    }

    /**
     * Create student assignments for all eligible students.
     *
     * @param int $assignmentId
     * @param \Illuminate\Database\Eloquent\Collection $students
     * @return void
     */
    private function createStudentAssignments(int $assignmentId, \Illuminate\Database\Eloquent\Collection $students): void
    {
        foreach ($students as $student) {
            StudentAssignment::create([
                'assignment_id' => $assignmentId,
                'student_id' => $student->id,
                'status' => 'pending',
                'created_by' => Auth::id(),
            ]);
        }
    }

    /**
     * Send assignment notifications to students.
     *
     * @param Assignment $assignment
     * @param \Illuminate\Database\Eloquent\Collection $students
     * @return void
     */
    private function sendAssignmentNotifications(Assignment $assignment, \Illuminate\Database\Eloquent\Collection $students): void
    {
        $notificationData = [
            'id' => $assignment->id,
            'title' => $assignment->title,
            'type' => 'assignment'
        ];

        // Note: You'll need to create the AssignmentNotification class
        // Notification::send($students, new AssignmentNotification($notificationData));
    }

    /**
     * Get assignment statistics.
     *
     * @param int $assignmentId
     * @return array
     */
    public function getAssignmentStatistics(int $assignmentId): array
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $totalStudents = StudentAssignment::where('assignment_id', $assignmentId)->count();
        $submitted = StudentAssignment::where('assignment_id', $assignmentId)
            ->where('status', 'submitted')
            ->count();
        $graded = StudentAssignment::where('assignment_id', $assignmentId)
            ->where('status', 'graded')
            ->count();
        $pending = $totalStudents - $submitted;

        return [
            'total_students' => $totalStudents,
            'submitted' => $submitted,
            'graded' => $graded,
            'pending' => $pending,
            'submission_rate' => $totalStudents > 0 ? round(($submitted / $totalStudents) * 100, 2) : 0,
            'grading_rate' => $submitted > 0 ? round(($graded / $submitted) * 100, 2) : 0,
        ];
    }

    /**
     * Get assignments by teacher.
     *
     * @param Request $request
     * @param int $teacherId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTeacherAssignments(Request $request, int $teacherId): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        // Prepare filters array for the scope
        $filters = $request->only([
            'status', 'search', 'start_date', 'end_date'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code'
        ])
        ->filterByTeacher($teacherId)
        ->filterBy($filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | Scope-Based Methods
    |--------------------------------------------------------------------------
    |
    | These methods utilize the model scopes for common assignment queries.
    |
    */

    /**
     * Get currently running assignments.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getCurrentlyRunningAssignments(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->currentlyRunning()
        ->filterBy($filters);

        return $query->orderBy('end_date', 'asc')->paginate($perPage);
    }

    /**
     * Get overdue assignments.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getOverdueAssignments(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->overdue()
        ->filterBy($filters);

        return $query->orderBy('end_date', 'desc')->paginate($perPage);
    }

    /**
     * Get upcoming assignments.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUpcomingAssignments(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->upcoming()
        ->filterBy($filters);

        return $query->orderBy('start_date', 'asc')->paginate($perPage);
    }

    /**
     * Get active assignments.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getActiveAssignments(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'search',
            'start_date', 'end_date'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->active()
        ->filterBy($filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get assignments by date range.
     *
     * @param Request $request
     * @param string $startDate
     * @param string|null $endDate
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAssignmentsByDateRange(Request $request, string $startDate, ?string $endDate = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
        
        $filters = $request->only([
            'faculty_id', 'program_id', 'session_id', 'semester_id', 
            'section_id', 'subject_id', 'teacher_id', 'status', 'search'
        ]);

        $query = Assignment::with([
            'faculty:id,title',
            'program:id,title',
            'session:id,title',
            'semester:id,title',
            'section:id,title',
            'subject:id,title,code',
            'teacher:id,first_name,last_name'
        ])
        ->filterByDateRange($startDate, $endDate)
        ->filterBy($filters);

        return $query->orderBy('start_date', 'asc')->paginate($perPage);
    }
}
