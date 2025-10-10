<?php

namespace App\Services\v1;

use App\Enums\v1\ApplicationStatus;
use App\Models\v1\Application;
use App\Models\v1\Batch;
use App\Models\v1\Program;
use App\Models\v1\Province;
use App\Models\v1\District;
use App\Traits\v1\FileUploader;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
     * Create a new application.
     *
     * @param array $data Application data including personal info, academic records, etc.
     * @return Application Created application instance with relationships
     * @throws Exception When creation fails
     */
    public function createApplication(array $data): Application
    {
        return DB::transaction(function () use ($data) {
            // Handle file uploads
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
                    disk: 'public',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['school_certificate']) && $data['school_certificate']) {
                $data['school_certificate'] = $this->uploadMedia(
                    file: $data['school_certificate'],
                    directory: 'applications',
                    disk: 'public',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['college_transcript']) && $data['college_certificate']) {
                $data['college_certificate'] = $this->uploadMedia(
                    file: $data['college_certificate'],
                    directory: 'applications',
                    disk: 'public',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            if (isset($data['college_certificate']) && $data['collage_certificate']) {
                $data['collage_certificate'] = $this->uploadMedia(
                    file: $data['collage_certificate'],
                    directory: 'applications',
                    disk: 'public',
                    allowedExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
                    maxSize: 5 * 1024 * 1024 // 5MB
                );
            }

            $application = Application::query()->create($data);

            return $application->load(['batch', 'program', 'presentProvince', 'presentDistrict', 'permanentProvince', 'permanentDistrict']);
        });
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
            $documentFields = ['school_transcript', 'school_certificate', 'college_certificate', 'collage_certificate'];
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
            $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'college_certificate', 'collage_certificate'];
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
                $fileFields = ['photo', 'signature', 'father_photo', 'mother_photo', 'school_transcript', 'school_certificate', 'college_certificate', 'collage_certificate'];
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
}
