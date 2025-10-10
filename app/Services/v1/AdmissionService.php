<?php

namespace App\Services\v1;

use App\Enums\v1\ApplicationStatus;
use App\Enums\v1\Status;
use App\Models\v1\Application;
use App\Models\v1\Document;
use App\Models\v1\EnrollSubject;
use App\Models\v1\Student;
use App\Models\v1\StudentEnroll;
use App\Models\v1\StudentRelative;
use App\Traits\v1\FileUploader;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * AdmissionService - Version 1
 *
 * Service for managing admission operations in the College Management System.
 * This service handles applications, application status management, and application-related business logic.
 *
 * @version 1.0.0
 *
 * @author Softmax Technologies
 */
class AdmissionService
{
    use FileUploader;

    /*
    |--------------------------------------------------------------------------
    | Application Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all application-related operations including CRUD operations
    | for applications, application search, and application filtering by status, program,
    | and batch. Application management includes creating, updating, deleting, and retrieving
    | application information with support for file handling, status tracking, and comprehensive
    | search capabilities.
    |
    */

    /**
     * Get a paginated list of applications with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $batchId Filter by batch ID
     * @param int|null $programId Filter by program ID
     * @param string|null $status Filter by application status
     * @param string|null $payStatus Filter by payment status
     * @param string|null $search Search term for name, email, or registration number
     * @param string|null $startDate Filter by start date
     * @param string|null $endDate Filter by end date
     * @return LengthAwarePaginator Paginated list of applications
     */
    public function getApplications(int $perPage, ?int $batchId = null, ?int $programId = null, ?string $status = null, ?string $payStatus = null, ?string $search = null, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
        $query = Application::with(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'])
            ->when($batchId, fn($q) => $q->filterByBatch($batchId))
            ->when($programId, fn($q) => $q->filterByProgram($programId))
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($payStatus, fn($q) => $q->filterByPaymentStatus($payStatus))
            ->when($search, fn($q) => $q->search($search))
            ->when($startDate, fn($q) => $q->whereDate('apply_date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('apply_date', '<=', $endDate));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific application by ID.
     *
     * @param int $id Application ID
     * @return Application Application model instance with relationships
     * @throws ModelNotFoundException When application is not found
     */
    public function getApplicationById(int $id): Application
    {
        return Application::with(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'])->findOrFail($id);
    }

    /**
     * Create a new application and optionally convert to student.
     *
     * @param array $data Application data including personal info, academic records, etc.
     * @param bool $createStudent Whether to create student immediately (like UniversitySystem)
     * @param array $studentData Additional data for student creation (session, semester, section, etc.)
     * @return array Created application and optionally student data
     * @throws Exception When creation fails
     */
    public function createApplication(array $data, bool $createStudent = false, array $studentData = []): array
    {
        return DB::transaction(function () use ($data, $createStudent, $studentData) {
            if (isset($data['photo']) && $data['photo']) {
                $data['photo'] = $this->uploadImage(
                    file: $data['photo'],
                    directory: 'applications',
                    width: 300,
                    height: 300
                );
            }

            if (isset($data['signature']) && $data['signature']) {
                $data['signature'] = $this->uploadImage(
                    file: $data['signature'],
                    directory: 'applications',
                    width: 300,
                    height: 100
                );
            }

            if (isset($data['father_photo']) && $data['father_photo']) {
                $data['father_photo'] = $this->uploadImage(
                    file: $data['father_photo'],
                    directory: 'applications',
                    width: 300,
                    height: 300
                );
            }

            if (isset($data['mother_photo']) && $data['mother_photo']) {
                $data['mother_photo'] = $this->uploadImage(
                    file: $data['mother_photo'],
                    directory: 'applications',
                    width: 300,
                    height: 300
                );
            }

            if (isset($data['school_transcript']) && $data['school_transcript']) {
                $data['school_transcript'] = $this->uploadMedia(
                    file: $data['school_transcript'],
                    directory: 'applications',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['school_certificate']) && $data['school_certificate']) {
                $data['school_certificate'] = $this->uploadMedia(
                    file: $data['school_certificate'],
                    directory: 'applications',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['college_transcript']) && $data['college_transcript']) {
                $data['college_transcript'] = $this->uploadMedia(
                    file: $data['college_transcript'],
                    directory: 'applications',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['college_certificate']) && $data['college_certificate']) {
                $data['college_certificate'] = $this->uploadMedia(
                    file: $data['college_certificate'],
                    directory: 'applications',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            // Create application
            $application = Application::query()->create($data);
            $application->load(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict']);

            $result = ['application' => $application];

            // If createStudent is true, create student immediately (like UniversitySystem)
            if ($createStudent && !empty($studentData)) {
                $studentResult = $this->createStudentFromApplication($application, $studentData);
                $result = array_merge($result, $studentResult);
            }

            return $result;
        });
    }

    /**
     * Create student from application data (internal method).
     *
     * @param Application $application Application instance
     * @param array $studentData Additional student data
     * @return array Student creation result
     * @throws Exception When student creation fails
     */
    protected function createStudentFromApplication(Application $application, array $studentData): array
    {
        // Generate random password
        $password = Str::password(8);

        // Create student data from application
        $studentRecord = [
            'student_id' => $studentData['student_id'],
            'registration_no' => $application->registration_no,
            'batch_id' => $application->batch_id,
            'program_id' => $application->program_id,
            'admission_date' => $studentData['admission_date'] ?? now(),

            // Personal Information
            'first_name' => $application->first_name,
            'last_name' => $application->last_name,
            'father_name' => $application->father_name,
            'mother_name' => $application->mother_name,
            'father_occupation' => $application->father_occupation,
            'mother_occupation' => $application->mother_occupation,
            'email' => $application->email,
            'password' => Hash::make($password),
            'password_text' => Crypt::encryptString($password),

            // Address Information
            'country' => $application->country,
            'present_province' => $application->present_province,
            'present_district' => $application->present_district,
            'present_village' => $application->present_village,
            'present_address' => $application->present_address,
            'permanent_province' => $application->permanent_province,
            'permanent_district' => $application->permanent_district,
            'permanent_village' => $application->permanent_village,
            'permanent_address' => $application->permanent_address,

            // Personal Details
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

            // Academic Information
            'school_name' => $application->school_name,
            'school_exam_id' => $application->school_exam_id,
            'school_graduation_year' => $application->school_graduation_year,
            'school_graduation_point' => $application->school_graduation_point,
            'college_name' => $application->college_name,
            'college_exam_id' => $application->college_exam_id,
            'college_graduation_year' => $application->college_graduation_year,
            'college_graduation_point' => $application->college_graduation_point,

            // File paths
            'photo' => $application->photo,
            'signature' => $application->signature,
            'father_photo' => $application->father_photo,
            'mother_photo' => $application->mother_photo,
            'school_transcript' => $application->school_transcript,
            'school_certificate' => $application->school_certificate,
            'college_transcript' => $application->college_transcript,
            'college_certificate' => $application->college_certificate,

            'status' => Status::ACTIVE->value,
            'created_by' => auth()->id() ?? 1,
        ];

        // Create student
        $student = Student::query()->create($studentRecord);

        // Handle student relatives if provided
        if (isset($studentData['relatives']) && is_array($studentData['relatives'])) {
            $this->createStudentRelatives($student->id, $studentData['relatives']);
        }

        // Handle additional documents if provided
        if (isset($studentData['documents']) && is_array($studentData['documents'])) {
            $this->createStudentDocuments($student->id, $studentData['documents']);
        }

        // Create student enrollment
        $enrollment = $this->createStudentEnrollment($student->id, $studentData);

        // Assign subjects based on program/semester/section
        $this->assignSubjectsToStudent($enrollment->id, $studentData);

        // Update application status to admitted
        $application->update([
            'status' => ApplicationStatus::ADMITTED->value,
            'updated_by' => auth()->id(),
        ]);

        return [
            'student' => $student->load(['batch', 'program']),
            'enrollment' => $enrollment,
            'password' => $password
        ];
    }

    /**
     * Create student relatives.
     *
     * @param int $studentId Student ID
     * @param array $relatives Relatives data
     * @return void
     */
    protected function createStudentRelatives(int $studentId, array $relatives): void
    {
        foreach ($relatives as $relative) {
            if (!empty($relative['relation']) && !empty($relative['name'])) {
                StudentRelative::query()->create([
                    'student_id' => $studentId,
                    'relation' => $relative['relation'],
                    'name' => $relative['name'],
                    'occupation' => $relative['occupation'] ?? null,
                    'phone' => $relative['phone'] ?? null,
                    'address' => $relative['address'] ?? null,
                ]);
            }
        }
    }

    /**
     * Create student documents.
     *
     * @param int $studentId Student ID
     * @param array $documents Documents data
     * @return void
     */
    protected function createStudentDocuments(int $studentId, array $documents): void
    {
        foreach ($documents as $document) {
            if (!empty($document['title']) && !empty($document['file_path'])) {
                $filePath = $this->uploadMedia(
                    file: $document['file_path'],
                    directory: 'student-documents',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );

                if ($filePath) {
                    $documentModel = Document::query()->create([
                        'title' => $document['title'],
                        'file_path' => $filePath,
                        'status' => Status::ACTIVE->value,
                    ]);

                    $documentModel->students()->attach($studentId);
                }
            }
        }
    }

    /**
     * Create student enrollment.
     *
     * @param int $studentId Student ID
     * @param array $data Enrollment data
     * @return StudentEnroll
     */
    protected function createStudentEnrollment(int $studentId, array $data): StudentEnroll
    {
        return StudentEnroll::query()->create([
            'student_id' => $studentId,
            'program_id' => $data['program_id'],
            'session_id' => $data['session_id'],
            'semester_id' => $data['semester_id'],
            'section_id' => $data['section_id'],
            'created_by' => auth()->id() ?? 1,
            'status' => 'active',
        ]);
    }

    /**
     * Assign subjects to student based on program/semester/section.
     *
     * @param int $enrollmentId Enrollment ID
     * @param array $data Enrollment data
     * @return void
     */
    protected function assignSubjectsToStudent(int $enrollmentId, array $data): void
    {
        $enrollment = StudentEnroll::query()->findOrFail($enrollmentId);

        // Find enroll subject configuration
        $enrollSubject = EnrollSubject::query()->where('program_id', $data['program_id'])
            ->where('semester_id', $data['semester_id'])
            ->where('section_id', $data['section_id'])
            ->first();

        if ($enrollSubject) {
            foreach ($enrollSubject->subjects as $subject) {
                $enrollment->subjects()->attach($subject->id);
            }
        }
    }

    /**
     * Update an existing application.
     *
     * @param int $id Application ID to update
     * @param array $data Updated application data including file handling
     * @return Application Updated application instance with relationships
     * @throws ModelNotFoundException When application is not found
     * @throws Exception When update fails
     */
    public function updateApplication(int $id, array $data): Application
    {
        return DB::transaction(function () use ($data, $id) {
            $application = Application::query()->findOrFail($id);

            // Handle file uploads
            if (isset($data['photo']) && $data['photo']) {
                if ($application->photo) {
                    $data['photo'] = $this->updateImage(
                        file: $data['photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300,
                        model: $application,
                        field: 'photo'
                    );
                } else {
                    $data['photo'] = $this->uploadImage(
                        file: $data['photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300
                    );
                }
            }

            if (isset($data['signature']) && $data['signature']) {
                if ($application->signature) {
                    $data['signature'] = $this->updateImage(
                        file: $data['signature'],
                        directory: 'applications',
                        width: 300,
                        height: 100,
                        model: $application,
                        field: 'signature'
                    );
                } else {
                    $data['signature'] = $this->uploadImage(
                        file: $data['signature'],
                        directory: 'applications',
                        width: 300,
                        height: 100
                    );
                }
            }

            if (isset($data['father_photo']) && $data['father_photo']) {
                if ($application->father_photo) {
                    $data['father_photo'] = $this->updateImage(
                        file: $data['father_photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300,
                        model: $application,
                        field: 'father_photo'
                    );
                } else {
                    $data['father_photo'] = $this->uploadImage(
                        file: $data['father_photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300
                    );
                }
            }

            if (isset($data['mother_photo']) && $data['mother_photo']) {
                if ($application->mother_photo) {
                    $data['mother_photo'] = $this->updateImage(
                        file: $data['mother_photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300,
                        model: $application,
                        field: 'mother_photo'
                    );
                } else {
                    $data['mother_photo'] = $this->uploadImage(
                        file: $data['mother_photo'],
                        directory: 'applications',
                        width: 300,
                        height: 300
                    );
                }
            }

            // Handle document uploads
            $documentFields = ['school_transcript', 'school_certificate', 'college_certificate', 'college_certificate'];
            foreach ($documentFields as $field) {
                if (isset($data[$field]) && $data[$field]) {
                    if ($application->$field) {
                        $data[$field] = $this->updateMedia(
                            file: $data[$field],
                            directory: 'applications',
                            disk: 'public',
                            oldFilePath: $application->$field,
                            allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                            maxSize: 5 * 1024 * 1024 // 5MB
                        );
                    } else {
                        $data[$field] = $this->uploadMedia(
                            file: $data[$field],
                            directory: 'applications',
                            disk: 'public',
                            allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                            maxSize: 5 * 1024 * 1024 // 5MB
                        );
                    }
                }
            }

            $application->update($data);

            return $application->load(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict']);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Student Admission Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle the complete admission process including converting
    | approved applications to students, managing student relatives, documents,
    | enrollment, and subject assignments.
    |
    */

    /**
     * Delete an application.
     *
     * @param int $id Application ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When application is not found
     * @throws Exception When deletion fails
     */
    public function deleteApplication(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $application = Application::query()->findOrFail($id);

            // Delete associated files
            $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'college_certificate', 'college_certificate'];
            foreach ($fileFields as $field) {
                if ($application->$field) {
                    $this->deleteMedia($application->$field, 'public');
                }
            }

            $application->delete();

            return true;
        });
    }

    /**
     * Bulk update application status.
     *
     * @param array $ids Array of application IDs to update
     * @param string $status New status
     * @return int Number of applications updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateApplicationStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Application::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete applications.
     *
     * @param array $ids Array of application IDs to delete
     * @return int Number of applications successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteApplications(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $applications = Application::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($applications as $application) {
                // Delete associated files
                $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'college_certificate', 'college_certificate'];
                foreach ($fileFields as $field) {
                    if ($application->$field) {
                        $this->deleteMedia($application->$field, 'public');
                    }
                }

                $application->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Get application statistics.
     *
     * @return array Application statistics
     */
    public function getApplicationStatistics(): array
    {
        return [
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('status', ApplicationStatus::PENDING->value)->count(),
            'in_progress_applications' => Application::where('status', ApplicationStatus::IN_PROGRESS->value)->count(),
            'approved_applications' => Application::where('status', ApplicationStatus::APPROVED->value)->count(),
            'rejected_applications' => Application::where('status', ApplicationStatus::REJECTED->value)->count(),
            'admitted_applications' => Application::where('status', ApplicationStatus::ADMITTED->value)->count(),
        ];
    }

    /**
     * Get applications ready for admission (approved applications).
     *
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator Paginated list of approved applications
     */
    public function getApplicationsReadyForAdmission(int $perPage = 15): LengthAwarePaginator
    {
        return Application::with(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict'])
            ->where('status', ApplicationStatus::APPROVED->value)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Bulk convert applications to students.
     *
     * @param array $applicationIds Array of application IDs
     * @param array $defaultData Default data for all students
     * @return array Conversion results
     * @throws Exception When bulk conversion fails
     */
    public function bulkConvertApplicationsToStudents(array $applicationIds, array $defaultData): array
    {
        return DB::transaction(function () use ($applicationIds, $defaultData) {
            $results = [
                'successful' => [],
                'failed' => [],
                'total_processed' => count($applicationIds),
                'success_count' => 0,
                'failed_count' => 0
            ];

            foreach ($applicationIds as $applicationId) {
                try {
                    $result = $this->convertApplicationToStudent($applicationId, $defaultData);
                    $results['successful'][] = [
                        'application_id' => $applicationId,
                        'student_id' => $result['student']->id,
                        'student_name' => $result['student']->first_name . ' ' . $result['student']->last_name,
                        'password' => $result['password']
                    ];
                    $results['success_count']++;
                } catch (Exception $e) {
                    $results['failed'][] = [
                        'application_id' => $applicationId,
                        'error' => $e->getMessage()
                    ];
                    $results['failed_count']++;
                }
            }

            return $results;
        });
    }

    /**
     * Convert approved application to student.
     *
     * @param int $applicationId Application ID to convert
     * @param array $additionalData Additional student data (student_id, session, semester, section, etc.)
     * @return array Created student and related data
     * @throws Exception When conversion fails
     */
    public function convertApplicationToStudent(int $applicationId, array $additionalData): array
    {
        return DB::transaction(function () use ($applicationId, $additionalData) {
            $application = Application::with(['batch', 'program'])->findOrFail($applicationId);

            // Validate application is approved
            if ($application->status !== ApplicationStatus::APPROVED->value) {
                throw new Exception('Application must be approved before converting to student');
            }

            // Generate random password
            $password = Str::random(8);

            // Create student from application data
            $studentData = [
                'student_id' => $additionalData['student_id'],
                'registration_no' => $application->registration_no,
                'batch_id' => $application->batch_id,
                'program_id' => $application->program_id,
                'admission_date' => $additionalData['admission_date'] ?? now(),

                // Personal Information
                'first_name' => $application->first_name,
                'last_name' => $application->last_name,
                'father_name' => $application->father_name,
                'mother_name' => $application->mother_name,
                'father_occupation' => $application->father_occupation,
                'mother_occupation' => $application->mother_occupation,
                'email' => $application->email,
                'password' => Hash::make($password),
                'password_text' => Crypt::encryptString($password),

                // Address Information
                'country' => $application->country,
                'present_province' => $application->present_province,
                'present_district' => $application->present_district,
                'present_village' => $application->present_village,
                'present_address' => $application->present_address,
                'permanent_province' => $application->permanent_province,
                'permanent_district' => $application->permanent_district,
                'permanent_village' => $application->permanent_village,
                'permanent_address' => $application->permanent_address,

                // Personal Details
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

                // Academic Information
                'school_name' => $application->school_name,
                'school_exam_id' => $application->school_exam_id,
                'school_graduation_year' => $application->school_graduation_year,
                'school_graduation_point' => $application->school_graduation_point,
                'college_name' => $application->college_name,
                'college_exam_id' => $application->college_exam_id,
                'college_graduation_year' => $application->college_graduation_year,
                'college_graduation_point' => $application->college_graduation_point,

                // File paths
                'photo' => $application->photo,
                'signature' => $application->signature,
                'father_photo' => $application->father_photo,
                'mother_photo' => $application->mother_photo,
                'school_transcript' => $application->school_transcript,
                'school_certificate' => $application->school_certificate,
                'college_transcript' => $application->college_transcript,
                'college_certificate' => $application->college_certificate,

                'status' => '1',
                'created_by' => auth()->id(),
            ];

            // Create student
            $student = Student::create($studentData);

            // Handle student relatives if provided
            if (isset($additionalData['relatives']) && is_array($additionalData['relatives'])) {
                $this->createStudentRelatives($student->id, $additionalData['relatives']);
            }

            // Handle additional documents if provided
            if (isset($additionalData['documents']) && is_array($additionalData['documents'])) {
                $this->createStudentDocuments($student->id, $additionalData['documents']);
            }

            // Create student enrollment
            $enrollment = $this->createStudentEnrollment($student->id, $additionalData);

            // Assign subjects based on program/semester/section
            $this->assignSubjectsToStudent($enrollment->id, $additionalData);

            // Update application status to admitted
            $application->update([
                'status' => ApplicationStatus::ADMITTED->value,
                'updated_by' => auth()->id() ?? 1,
            ]);

            return [
                'student' => $student->load(['batch', 'program']),
                'enrollment' => $enrollment,
                'password' => $password,
                'application' => $application
            ];
        });
    }
}
