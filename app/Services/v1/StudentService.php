<?php

namespace App\Services\v1;

use App\Models\v1\Student;
use App\Models\v1\Application;
use App\Models\v1\StudentEnroll;
use App\Models\v1\Batch;
use App\Models\v1\Program;
use App\Models\v1\Session;
use App\Models\v1\Semester;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

/**
 * Student Service - Version 1
 *
 * This service handles all student-related operations including creation,
 * enrollment management, and academic record tracking in the College Management System.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentService
{
    /**
     * Create a new student from application.
     *
     * @param int $applicationId
     * @param array $additionalData
     * @return Student
     * @throws Exception
     */
    public function createStudentFromApplication(int $applicationId, array $additionalData = []): Student
    {
        try {
            return DB::transaction(function () use ($applicationId, $additionalData) {
                $application = Application::findOrFail($applicationId);

                // Check if application is approved
                if ($application->status != 2) {
                    throw new Exception('Application must be approved before creating student');
                }

                // Check if student already exists for this application
                if (Student::where('email', $application->email)->exists()) {
                    throw new Exception('Student already exists for this application');
                }

                // Generate student ID
                $studentId = $this->generateStudentId($application->program_id);

                // Prepare student data from application
                $studentData = [
                    'student_id' => $studentId,
                    'registration_no' => $application->registration_no,
                    'batch_id' => $application->batch_id,
                    'program_id' => $application->program_id,
                    'admission_date' => now()->toDateString(),
                    'first_name' => $application->first_name,
                    'last_name' => $application->last_name,
                    'father_name' => $application->father_name,
                    'mother_name' => $application->mother_name,
                    'father_occupation' => $application->father_occupation,
                    'mother_occupation' => $application->mother_occupation,
                    'father_photo' => $application->father_photo,
                    'mother_photo' => $application->mother_photo,
                    'email' => $application->email,
                    'password' => Hash::make($additionalData['password'] ?? 'password123'),
                    'password_text' => $additionalData['password'] ?? 'password123',
                    'country' => $application->country,
                    'present_province' => $application->present_province,
                    'present_district' => $application->present_district,
                    'present_village' => $application->present_village,
                    'present_address' => $application->present_address,
                    'permanent_province' => $application->permanent_province,
                    'permanent_district' => $application->permanent_district,
                    'permanent_village' => $application->permanent_village,
                    'permanent_address' => $application->permanent_address,
                    'gender' => $application->gender,
                    'dob' => $application->dob,
                    'phone' => $application->phone,
                    'emergency_phone' => $application->emergency_phone,
                    'religion' => $application->religion,
                    'caste' => $application->caste,
                    'mother_tongue' => $application->mother_tongue,
                    'marital_status' => $application->marital_status,
                    'blood_group' => $application->blood_group,
                    'nationality' => $application->nationality,
                    'national_id' => $application->national_id,
                    'passport_no' => $application->passport_no,
                    'school_name' => $application->school_name,
                    'school_exam_id' => $application->school_exam_id,
                    'school_graduation_field' => $application->school_graduation_field,
                    'school_graduation_year' => $application->school_graduation_year,
                    'school_graduation_point' => $application->school_graduation_point,
                    'school_transcript' => $application->school_transcript,
                    'school_certificate' => $application->school_certificate,
                    'collage_name' => $application->collage_name,
                    'collage_exam_id' => $application->collage_exam_id,
                    'collage_graduation_field' => $application->collage_graduation_field,
                    'collage_graduation_year' => $application->collage_graduation_year,
                    'collage_graduation_point' => $application->collage_graduation_point,
                    'collage_transcript' => $application->collage_transcript,
                    'collage_certificate' => $application->collage_certificate,
                    'photo' => $application->photo,
                    'signature' => $application->signature,
                    'login' => true,
                    'status' => 1, // Active
                    'is_transfer' => false,
                    'created_by' => auth()->id() ?? 1,
                ];

                // Merge additional data
                $studentData = array_merge($studentData, $additionalData);

                // Create the student
                $student = Student::create($studentData);

                return $student;
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to create student: ' . $th->getMessage());
        }
    }

    /**
     * Create a new student enrollment.
     *
     * @param int $studentId
     * @param array $enrollmentData
     * @return StudentEnroll
     * @throws Exception
     */
    public function enrollStudent(int $studentId, array $enrollmentData): StudentEnroll
    {
        try {
            return DB::transaction(function () use ($studentId, $enrollmentData) {
                $student = Student::findOrFail($studentId);

                // Validate enrollment data
                $this->validateEnrollmentData($enrollmentData);

                // Check if student is already enrolled in the same program/session/semester
                $existingEnrollment = StudentEnroll::where('student_id', $studentId)
                    ->where('program_id', $enrollmentData['program_id'])
                    ->where('session_id', $enrollmentData['session_id'])
                    ->where('semester_id', $enrollmentData['semester_id'])
                    ->where('status', 1)
                    ->first();

                if ($existingEnrollment) {
                    throw new Exception('Student is already enrolled in this program/session/semester');
                }

                // Create enrollment
                $enrollment = StudentEnroll::create([
                    'student_id' => $studentId,
                    'program_id' => $enrollmentData['program_id'],
                    'session_id' => $enrollmentData['session_id'],
                    'semester_id' => $enrollmentData['semester_id'],
                    'status' => 1, // Active
                ]);

                return $enrollment;
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to enroll student: ' . $th->getMessage());
        }
    }

    /**
     * Update student information.
     *
     * @param int $id
     * @param array $data
     * @return Student
     * @throws Exception
     */
    public function updateStudent(int $id, array $data): Student
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $student = Student::findOrFail($id);

                // Handle password update
                if (isset($data['password'])) {
                    $data['password'] = Hash::make($data['password']);
                    $data['password_text'] = $data['password_text'] ?? $data['password'];
                }

                // Update the student
                $student->update($data);

                return $student->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to update student: ' . $th->getMessage());
        }
    }

    /**
     * Get student by ID with relationships.
     *
     * @param int $id
     * @return Student
     * @throws Exception
     */
    public function getStudent(int $id): Student
    {
        try {
            return Student::with([
                'batch',
                'program.faculty',
                'presentProvince',
                'presentDistrict',
                'permanentProvince',
                'permanentDistrict',
                'studentEnrolls.session',
                'studentEnrolls.semester',
                'currentEnroll',
                'relatives'
            ])->findOrFail($id);
        } catch (Throwable $th) {
            throw new Exception('Student not found');
        }
    }

    /**
     * Get paginated students with filters.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getStudents(Request $request)
    {
        $query = Student::with([
            'batch',
            'program.faculty',
            'currentEnroll'
        ]);

        // Apply filters
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        if ($request->filled('program_id')) {
            $query->filterByProgram($request->program_id);
        }

        if ($request->filled('batch_id')) {
            $query->filterByBatch($request->batch_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply date filters
        if ($request->filled('from_date')) {
            $query->where('admission_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('admission_date', '<=', $request->to_date);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $perPage = $request->get('per_page', 15);
        return $query->paginate($perPage);
    }

    /**
     * Delete a student.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteStudent(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $student = Student::findOrFail($id);

                // Check if student can be deleted
                if ($student->status == 1) { // Active
                    throw new Exception('Cannot delete active student. Please deactivate first.');
                }

                return $student->delete();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to delete student: ' . $th->getMessage());
        }
    }

    /**
     * Transfer student to another program.
     *
     * @param int $studentId
     * @param int $newProgramId
     * @param string $reason
     * @return Student
     * @throws Exception
     */
    public function transferStudent(int $studentId, int $newProgramId, string $reason = ''): Student
    {
        try {
            return DB::transaction(function () use ($studentId, $newProgramId, $reason) {
                $student = Student::findOrFail($studentId);

                // Validate new program
                if (!Program::where('id', $newProgramId)->where('status', true)->exists()) {
                    throw new Exception('Invalid or inactive program selected');
                }

                // Update student program
                $student->update([
                    'program_id' => $newProgramId,
                    'is_transfer' => true,
                    'updated_by' => auth()->id() ?? 1,
                ]);

                // Deactivate current enrollments
                StudentEnroll::where('student_id', $studentId)
                    ->where('status', 1)
                    ->update(['status' => 0]);

                return $student->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to transfer student: ' . $th->getMessage());
        }
    }

    /**
     * Get student statistics.
     *
     * @return array
     */
    public function getStudentStatistics(): array
    {
        try {
            $total = Student::count();
            $active = Student::filterByStatus(1)->count();
            $inactive = Student::filterByStatus(0)->count();
            $passedOut = Student::filterByStatus(2)->count();
            $transferOut = Student::filterByStatus(3)->count();

            $thisMonth = Student::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'passed_out' => $passedOut,
                'transfer_out' => $transferOut,
                'this_month' => $thisMonth,
                'active_rate' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
            ];
        } catch (Throwable $th) {
            throw new Exception('Failed to get student statistics: ' . $th->getMessage());
        }
    }

    /**
     * Generate a unique student ID.
     *
     * @param int $programId
     * @return string
     */
    private function generateStudentId(int $programId): string
    {
        $year = now()->year;
        $program = Program::find($programId);
        $programCode = $program->shortcode ?? 'STD';
        $prefix = $programCode . $year;

        // Get the last student ID for this program and year
        $lastStudent = Student::where('student_id', 'like', $prefix . '%')
            ->orderBy('student_id', 'desc')
            ->first();

        if ($lastStudent) {
            // Extract the numeric part and increment
            $lastNumber = (int)substr($lastStudent->student_id, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Validate enrollment data.
     *
     * @param array $data
     * @throws Exception
     */
    private function validateEnrollmentData(array $data): void
    {
        // Validate program
        if (!Program::where('id', $data['program_id'])->where('status', true)->exists()) {
            throw new Exception('Invalid or inactive program selected');
        }

        // Validate session
        if (!Session::where('id', $data['session_id'])->where('status', true)->exists()) {
            throw new Exception('Invalid or inactive session selected');
        }

        // Validate semester
        if (!Semester::where('id', $data['semester_id'])->where('status', true)->exists()) {
            throw new Exception('Invalid or inactive semester selected');
        }
    }
}
