<?php

namespace App\Services\v1;

use App\Models\v1\Batch;
use App\Models\v1\ClassRoom;
use App\Models\v1\EnrollSubject;
use App\Models\v1\Faculty;
use App\Models\v1\Program;
use App\Models\v1\ProgramSemesterSection;
use App\Models\v1\Section;
use App\Models\v1\Semester;
use App\Models\v1\Session;
use App\Models\v1\Subject;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * AcademicService - Version 1
 *
 * Service for managing academic operations in the College Management System.
 * This service handles faculties, programs, batches, sections, semesters, subjects,
 * academic sessions, and classrooms business logic.
 *
 * @version 1.0.0
 *
 * @author Softmax Technologies
 */
class AcademicService
{
    /*
    |--------------------------------------------------------------------------
    | Faculty Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all faculty-related operations including CRUD operations
    | for faculties and faculty filtering. Faculty management includes creating,
    | updating, deleting, and retrieving faculty information with support for
    | pagination, searching, and status filtering.
    |
    */

    /**
     * Get a paginated list of faculties with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $search Search term for faculty name or description
     * @param string|null $status Filter by faculty status (active/inactive)
     * @return LengthAwarePaginator Paginated list of faculties
     */
    public function getFaculties(int $perPage, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = Faculty::query()
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific faculty by ID.
     *
     * @param int $id Faculty ID
     * @return Faculty Faculty model instance
     * @throws ModelNotFoundException When faculty is not found
     */
    public function getFacultyById(int $id): Faculty
    {
        return Faculty::query()->findOrFail($id);
    }

    /**
     * Create a new faculty.
     *
     * @param array $data Faculty data including name, description, status, etc.
     * @return Faculty Created faculty instance
     * @throws Exception When creation fails
     */
    public function createFaculty(array $data): Faculty
    {
        return DB::transaction(function () use ($data) {
            return Faculty::query()->create($data);
        });
    }

    /**
     * Update an existing faculty.
     *
     * @param int $id Faculty ID to update
     * @param array $data Updated faculty data
     * @return Faculty Updated faculty instance
     * @throws ModelNotFoundException When faculty is not found
     * @throws Exception When update fails
     */
    public function updateFaculty(int $id, array $data): Faculty
    {
        return DB::transaction(function () use ($data, $id) {
            $faculty = Faculty::query()->findOrFail($id);
            $faculty->update($data);
            return $faculty;
        });
    }

    /**
     * Delete a faculty (Soft Delete).
     *
     * @param int $id Faculty ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When faculty is not found
     * @throws Exception When faculty has associated programs
     */
    public function deleteFaculty(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $faculty = Faculty::query()->findOrFail($id);

            if ($faculty->programs()->exists()) {
                throw new Exception('Cannot delete faculty that contains programs. Please delete all programs first.');
            }

            $faculty->delete();
            return true;
        });
    }

    /**
     * Bulk update faculty status.
     *
     * @param array $ids Array of faculty IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of faculties updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateFacultyStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Faculty::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete faculties (Soft Delete).
     *
     * @param array $ids Array of faculty IDs to delete
     * @return int Number of faculties successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteFaculties(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $faculties = Faculty::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($faculties as $faculty) {
                if ($faculty->programs()->exists()) {
                    continue;
                }

                $faculty->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Program Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all program-related operations including CRUD operations
    | for programs and program filtering. Program management includes creating,
    | updating, deleting, and retrieving program information with support for
    | faculty association, degree type filtering, and comprehensive search capabilities.
    |
    */

    /**
     * Get a paginated list of programs with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $facultyId Filter by faculty ID
     * @param string|null $status Filter by program status (active/inactive)
     * @param string|null $search Search term for program name or description
     * @param string|null $degreeType Filter by degree type
     * @return LengthAwarePaginator Paginated list of programs
     */
    public function getPrograms(int $perPage, ?int $facultyId = null, ?string $status = null, ?string $search = null, ?string $degreeType = null): LengthAwarePaginator
    {
        $query = Program::with(['faculty'])
            ->when($facultyId, fn($q) => $q->filterByFaculty($facultyId))
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($degreeType, fn($q) => $q->filterByDegreeType($degreeType))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific program by ID.
     *
     * @param int $id Program ID
     * @return Program Program model instance with relationships
     * @throws ModelNotFoundException When program is not found
     */
    public function getProgramById(int $id): Program
    {
        return Program::with(['faculty', 'batches'])->findOrFail($id);
    }

    /**
     * Create a new program.
     *
     * @param array $data Program data including name, description, faculty_id, etc.
     * @return Program Created program instance with faculty relationship
     * @throws Exception When creation fails
     */
    public function createProgram(array $data): Program
    {
        return DB::transaction(function () use ($data) {
            $program = Program::query()->create($data);
            return $program->load(['faculty']);
        });
    }

    /**
     * Update an existing program.
     *
     * @param int $id Program ID to update
     * @param array $data Updated program data
     * @return Program Updated program instance with faculty relationship
     * @throws ModelNotFoundException When program is not found
     * @throws Exception When update fails
     */
    public function updateProgram(int $id, array $data): Program
    {
        return DB::transaction(function () use ($data, $id) {
            $program = Program::query()->findOrFail($id);
            $program->update($data);
            return $program->load(['faculty']);
        });
    }

    /**
     * Delete a program (Soft Delete).
     *
     * @param int $id Program ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When program is not found
     * @throws Exception When program has associated batches
     */
    public function deleteProgram(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $program = Program::query()->findOrFail($id);

            if ($program->batches()->exists()) {
                throw new Exception('Cannot delete program that contains batches. Please delete all batches first.');
            }

            $program->delete();
            return true;
        });
    }

    /**
     * Bulk update program status.
     *
     * @param array $ids Array of program IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of programs updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateProgramStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Program::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete programs (Soft Delete).
     *
     * @param array $ids Array of program IDs to delete
     * @return int Number of programs successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeletePrograms(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $programs = Program::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($programs as $program) {
                if ($program->batches()->exists()) {
                    continue;
                }

                $program->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Batch Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all batch-related operations including CRUD operations
    | for batches and batch filtering. Batch management includes creating,
    | updating, deleting, and retrieving batch information with support for
    | program associations, academic year filtering, and comprehensive search capabilities.
    |
    */

    /**
     * Get a paginated list of batches with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $status Filter by batch status (active/inactive)
     * @param string|null $search Search term for batch name or description
     * @param int|null $academicYear Filter by academic year
     * @return LengthAwarePaginator Paginated list of batches
     */
    public function getBatches(int $perPage, ?string $status = null, ?string $search = null, ?int $academicYear = null): LengthAwarePaginator
    {
        $query = Batch::query()->with(['programs'])
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($academicYear, fn($q) => $q->filterByAcademicYear($academicYear))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific batch by ID.
     *
     * @param int $id Batch ID
     * @return Batch Batch model instance with relationships
     * @throws ModelNotFoundException When batch is not found
     */
    public function getBatchById(int $id): Batch
    {
        return Batch::with(['programs', 'sections'])->findOrFail($id);
    }

    /**
     * Create a new batch.
     *
     * @param array $data Batch data including name, academic_year, programs, etc.
     * @return Batch Created batch instance with program relationships
     * @throws Exception When creation fails
     */
    public function createBatch(array $data): Batch
    {
        return DB::transaction(function () use ($data) {
            $batch = Batch::query()->create($data);
            $batch->programs()->attach($data['programs']);
            return $batch->load(['programs']);
        });
    }

    /**
     * Update an existing batch.
     *
     * @param int $id Batch ID to update
     * @param array $data Updated batch data
     * @return Batch Updated batch instance with program relationships
     * @throws ModelNotFoundException When batch is not found
     * @throws Exception When update fails
     */
    public function updateBatch(int $id, array $data): Batch
    {
        return DB::transaction(function () use ($data, $id) {
            $batch = Batch::query()->findOrFail($id);
            $batch->update($data);
            $batch->programs()->sync($data['programs']);
            return $batch->load(['programs']);
        });
    }

    /**
     * Delete a batch (Soft Delete).
     *
     * @param int $id Batch ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When batch is not found
     * @throws Exception When deletion fails
     */
    public function deleteBatch(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $batch = Batch::query()->findOrFail($id);
            $batch->programs()->detach();
            $batch->delete();
            return true;
        });
    }

    /**
     * Bulk update batch status.
     *
     * @param array $ids Array of batch IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of batches updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateBatchStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Batch::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete batches (Soft Delete).
     *
     * @param array $ids Array of batch IDs to delete
     * @return int Number of batches successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteBatches(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $batches = Batch::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($batches as $batch) {
                $batch->programs()->detach();
                $batch->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Section Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all section-related operations including CRUD operations
    | for sections and section filtering. Section management includes creating,
    | updating, deleting, and retrieving section information with support for
    | complex many-to-many relationships with programs, semesters, and items.
    |
    */

    /**
     * Get a paginated list of sections with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $batchId Filter by batch ID
     * @param string|null $status Filter by section status (active/inactive)
     * @param string|null $search Search term for section name or description
     * @return LengthAwarePaginator Paginated list of sections
     */
    public function getSections(int $perPage, ?int $batchId = null, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = Section::with(['programSemesters.program', 'programSemesters.semester'])
            ->when($batchId, fn($q) => $q->filterByBatch($batchId))
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific section by ID.
     *
     * @param int $id Section ID
     * @return Section Section model instance with relationships
     * @throws ModelNotFoundException When section is not found
     */
    public function getSectionById(int $id): Section
    {
        return Section::with(['programSemesters.program', 'programSemesters.semester'])->findOrFail($id);
    }

    /**
     * Create a new section.
     *
     * @param array $data Section data including name, programs, semesters, items, etc.
     * @return Section Created section instance with relationships
     * @throws Exception When creation fails
     */
    public function createSection(array $data): Section
    {
        return DB::transaction(function () use ($data) {
            $section = Section::query()->create($data);
            $this->createSectionRelationships($section, $data);
            return $section->load(['programSemesters.program', 'programSemesters.semester']);
        });
    }

    /**
     * Create section relationships (for new sections).
     *
     * @param Section $section Section instance
     * @param array $data Section data containing programs, semesters, and items
     * @return void
     */
    private function createSectionRelationships(Section $section, array $data): void
    {
        if (!isset($data['programs']) || !isset($data['semesters']) || !isset($data['items'])) {
            return;
        }

        $programs = $data['programs'];
        $semesters = $data['semesters'];
        $items = $data['items'];

        foreach ($items as $index => $item) {
            if (isset($programs[$index]) && isset($semesters[$index])) {
                ProgramSemesterSection::query()->updateOrCreate(
                    [
                        'program_id' => $programs[$index],
                        'semester_id' => $semesters[$index],
                        'section_id' => $section->id,
                    ],
                    [
                        'program_id' => $programs[$index],
                        'semester_id' => $semesters[$index],
                        'section_id' => $section->id,
                    ]
                );
            }
        }
    }

    /**
     * Update an existing section.
     *
     * @param int $id Section ID to update
     * @param array $data Updated section data
     * @return Section Updated section instance with relationships
     * @throws ModelNotFoundException When section is not found
     * @throws Exception When update fails
     */
    public function updateSection(int $id, array $data): Section
    {
        return DB::transaction(function () use ($data, $id) {
            $section = Section::query()->findOrFail($id);
            $section->update($data);
            $this->updateSectionRelationships($section, $data);
            return $section->load(['programSemesters.program', 'programSemesters.semester']);
        });
    }

    /**
     * Update section relationships (for existing sections).
     *
     * @param Section $section Section instance
     * @param array $data Section data containing programs, semesters, and items
     * @return void
     */
    private function updateSectionRelationships(Section $section, array $data): void
    {
        if (!isset($data['programs']) || !isset($data['semesters']) || !isset($data['items'])) {
            return;
        }

        $section->programSemesters()->delete();

        $programs = $data['programs'];
        $semesters = $data['semesters'];
        $items = $data['items'];

        foreach ($items as $index => $item) {
            if (isset($programs[$index]) && isset($semesters[$index])) {
                ProgramSemesterSection::query()->updateOrCreate(
                    [
                        'program_id' => $programs[$index],
                        'semester_id' => $semesters[$index],
                        'section_id' => $section->id,
                    ],
                    [
                        'program_id' => $programs[$index],
                        'semester_id' => $semesters[$index],
                        'section_id' => $section->id,
                    ]
                );
            }
        }
    }

    /**
     * Delete a section (Soft Delete).
     *
     * @param int $id Section ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When section is not found
     * @throws Exception When deletion fails
     */
    public function deleteSection(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $section = Section::query()->findOrFail($id);
            $section->delete();
            return true;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Semester Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all semester-related operations including CRUD operations
    | for semesters and semester filtering. Semester management includes creating,
    | updating, deleting, and retrieving semester information with support for
    | program associations, academic year filtering, and current semester tracking.
    |
    */

    /**
     * Bulk update section status.
     *
     * @param array $ids Array of section IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of sections updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateSectionStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Section::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete sections (Soft Delete).
     *
     * @param array $ids Array of section IDs to delete
     * @return int Number of sections successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteSections(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $sections = Section::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($sections as $section) {
                $section->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Get a paginated list of semesters with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $status Filter by semester status (active/inactive)
     * @param string|null $search Search term for semester name or description
     * @param int|null $academicYear Filter by academic year
     * @param bool|null $isCurrent Filter by current semester status
     * @return LengthAwarePaginator Paginated list of semesters
     */
    public function getSemesters(int $perPage, ?string $status = null, ?string $search = null, ?int $academicYear = null, ?bool $isCurrent = null): LengthAwarePaginator
    {
        $query = Semester::query()->with(['programs'])
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($academicYear, fn($q) => $q->filterByAcademicYear($academicYear))
            ->when($isCurrent !== null, fn($q) => $q->current($isCurrent))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific semester by ID.
     *
     * @param int $id Semester ID
     * @return Semester Semester model instance
     * @throws ModelNotFoundException When semester is not found
     */
    public function getSemesterById(int $id): Semester
    {
        return Semester::query()->findOrFail($id);
    }

    /**
     * Create a new semester.
     *
     * @param array $data Semester data including name, academic_year, programs, etc.
     * @return Semester Created semester instance with program relationships
     * @throws Exception When creation fails
     */
    public function createSemester(array $data): Semester
    {
        return DB::transaction(function () use ($data) {
            $semester = Semester::query()->create($data);
            $semester->programs()->attach($data['programs']);
            return $semester->load(['programs']);
        });
    }

    /**
     * Update an existing semester.
     *
     * @param int $id Semester ID to update
     * @param array $data Updated semester data
     * @return Semester Updated semester instance with program relationships
     * @throws ModelNotFoundException When semester is not found
     * @throws Exception When update fails
     */
    public function updateSemester(int $id, array $data): Semester
    {
        return DB::transaction(function () use ($data, $id) {
            $semester = Semester::query()->findOrFail($id);
            $semester->update($data);
            $semester->programs()->sync($data['programs']);
            return $semester->load(['programs']);
        });
    }

    /**
     * Delete a semester (Soft Delete).
     *
     * @param int $id Semester ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When semester is not found
     * @throws Exception When deletion fails
     */
    public function deleteSemester(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $semester = Semester::query()->findOrFail($id);
            $semester->programs()->detach();
            $semester->delete();
            return true;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Subject Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all subject-related operations including CRUD operations
    | for subjects and subject filtering. Subject management includes creating,
    | updating, deleting, and retrieving subject information with support for
    | program associations, faculty filtering, subject type classification, and
    | credit hours management.
    |
    */

    /**
     * Bulk update semester status.
     *
     * @param array $ids Array of semester IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of semesters updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateSemesterStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Semester::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete semesters (Soft Delete).
     *
     * @param array $ids Array of semester IDs to delete
     * @return int Number of semesters successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteSemesters(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $semesters = Semester::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($semesters as $semester) {
                $semester->programs()->detach();
                $semester->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Get a paginated list of subjects with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $facultyId Filter by faculty ID
     * @param int|null $programId Filter by program ID
     * @param string|null $status Filter by subject status (active/inactive)
     * @param string|null $search Search term for subject name or description
     * @param string|null $subjectType Filter by subject type
     * @param string|null $classType Filter by class type
     * @param int|null $creditHours Filter by credit hours
     * @return LengthAwarePaginator Paginated list of subjects
     */
    public function getSubjects(int $perPage, ?int $facultyId, ?int $programId, ?string $status = null, ?string $search = null, ?string $subjectType = null, ?string $classType = null, ?int $creditHours = null): LengthAwarePaginator
    {
        $query = Subject::query()->with(['programs', 'programs.faculty'])
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($facultyId, fn($q) => $q->filterByFaculty($facultyId))
            ->when($programId, fn($q) => $q->filterByProgram($programId))
            ->when($subjectType, fn($q) => $q->filterBySubjectType($subjectType))
            ->when($classType, fn($q) => $q->filterByClassType($classType))
            ->when($creditHours, fn($q) => $q->filterByCreditHours($creditHours))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    /**
     * Get a specific subject by ID.
     *
     * @param int $id Subject ID
     * @return Subject Subject model instance with relationships
     * @throws ModelNotFoundException When subject is not found
     */
    public function getSubjectById(int $id): Subject
    {
        return Subject::with(['programs', 'programs.faculty'])->findOrFail($id);
    }

    /**
     * Create a new subject.
     *
     * @param array $data Subject data including name, description, programs, etc.
     * @return Subject Created subject instance with program relationships
     * @throws Exception When creation fails
     */
    public function createSubject(array $data): Subject
    {
        return DB::transaction(function () use ($data) {
            $subject = Subject::query()->create($data);
            $subject->programs()->attach($data['programs']);
            return $subject->load(['programs', 'programs.faculty']);
        });
    }

    /**
     * Update an existing subject.
     *
     * @param int $id Subject ID to update
     * @param array $data Updated subject data
     * @return Subject Updated subject instance with program relationships
     * @throws ModelNotFoundException When subject is not found
     * @throws Exception When update fails
     */
    public function updateSubject(int $id, array $data): Subject
    {
        return DB::transaction(function () use ($data, $id) {
            $subject = Subject::query()->findOrFail($id);
            $subject->update($data);
            $subject->programs()->sync($data['programs']);
            return $subject->load(['programs', 'programs.faculty']);
        });
    }

    /**
     * Delete a subject (Soft Delete).
     *
     * @param int $id Subject ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When subject is not found
     * @throws Exception When deletion fails
     */
    public function deleteSubject(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $subject = Subject::query()->findOrFail($id);
            $subject->programs()->detach();
            $subject->delete();
            return true;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Academic Session Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all academic session-related operations including CRUD operations
    | for academic sessions and academic session filtering. Academic session management
    | includes creating, updating, deleting, and retrieving session information with support
    | for program associations, current session tracking, and comprehensive filtering.
    |
    */

    /**
     * Bulk update subject status.
     *
     * @param array $ids Array of subject IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of subjects updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateSubjectStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Subject::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete subjects (Soft Delete).
     *
     * @param array $ids Array of subject IDs to delete
     * @return int Number of subjects successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteSubjects(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $subjects = Subject::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($subjects as $subject) {
                $subject->programs()->detach();
                $subject->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Get a paginated list of academic sessions with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $status Filter by session status (active/inactive)
     * @param string|null $search Search term for session name or description
     * @param bool|null $isCurrent Filter by current session status
     * @return LengthAwarePaginator Paginated list of academic sessions
     */
    public function getAcademicSessions(int $perPage, ?string $status = null, ?string $search = null, ?bool $isCurrent = null): LengthAwarePaginator
    {
        $query = Session::query()->with(['programs'])
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($isCurrent !== null, fn($q) => $q->current($isCurrent))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific academic session by ID.
     *
     * @param int $id Academic session ID
     * @return Session Academic session model instance with relationships
     * @throws ModelNotFoundException When academic session is not found
     */
    public function getAcademicSessionById(int $id): Session
    {
        return Session::with(['programs'])->findOrFail($id);
    }

    /**
     * Create a new academic session.
     *
     * @param array $data Academic session data including name, programs, is_current, etc.
     * @return Session Created academic session instance with program relationships
     * @throws Exception When creation fails
     */
    public function createAcademicSession(array $data): Session
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['is_current']) && $data['is_current']) {
                Session::query()->where('is_current', true)->update(['is_current' => false]);
            }
            $session = Session::query()->create($data);
            $session->programs()->attach($data['programs']);
            return $session->load(['programs']);
        });
    }

    /**
     * Update an existing academic session.
     *
     * @param int $id Academic session ID to update
     * @param array $data Updated academic session data
     * @return Session Updated academic session instance with program relationships
     * @throws ModelNotFoundException When academic session is not found
     * @throws Exception When update fails
     */
    public function updateAcademicSession(int $id, array $data): Session
    {
        return DB::transaction(function () use ($data, $id) {
            $academicSession = Session::query()->findOrFail($id);
            if (isset($data['is_current']) && $data['is_current']) {
                Session::query()
                    ->where('is_current', true)
                    ->where('id', '!=', $id)
                    ->update(['is_current' => false]);
            }
            $academicSession->update($data);
            $academicSession->programs()->sync($data['programs']);
            return $academicSession->load(['programs']);
        });
    }

    /**
     * Delete an academic session (Soft Delete).
     *
     * @param int $id Academic session ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When academic session is not found
     * @throws Exception When deletion fails
     */
    public function deleteAcademicSession(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $academicSession = Session::query()->findOrFail($id);
            $academicSession->programs()->detach();
            $academicSession->delete();
            return true;
        });
    }

    /**
     * Bulk update academic session status.
     *
     * @param array $ids Array of academic session IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of academic sessions updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateAcademicSessionStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Session::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ClassRoom Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all classroom-related operations including CRUD operations
    | for classrooms and classroom filtering. Classroom management includes creating,
    | updating, deleting, and retrieving classroom information with support for
    | program associations, room type classification, availability tracking, and
    | capacity management.
    |
    */

    /**
     * Bulk delete academic sessions (Soft Delete).
     *
     * @param array $ids Array of academic session IDs to delete
     * @return int Number of academic sessions successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteAcademicSessions(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $academicSessions = Session::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($academicSessions as $academicSession) {
                $academicSession->programs()->detach();
                $academicSession->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Set a specific academic session as the current session.
     *
     * This method ensures that only one session is marked as 'is_current' at a time.
     *
     * @param int $id The ID of the session to set as current
     * @return Session Updated academic session instance
     * @throws ModelNotFoundException When academic session is not found
     * @throws Exception When setting current session fails
     */
    public function setCurrentAcademicSession(int $id): Session
    {
        return DB::transaction(function () use ($id) {
            Session::query()
                ->where('is_current', true)
                ->where('id', '!=', $id)
                ->update(['is_current' => false]);

            $session = Session::query()->findOrFail($id);
            $session->is_current = true;
            $session->save();

            return $session;
        });
    }

    /**
     * Get a paginated list of classrooms with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $status Filter by classroom status (active/inactive)
     * @param string|null $search Search term for classroom name or description
     * @param string|null $roomType Filter by room type
     * @param bool|null $isAvailable Filter by availability status
     * @return LengthAwarePaginator Paginated list of classrooms
     */
    public function getClassRooms(int $perPage, ?string $status = null, ?string $search = null, ?string $roomType = null, ?bool $isAvailable = null): LengthAwarePaginator
    {
        $query = ClassRoom::query()->with(['programs'])
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($roomType, fn($q) => $q->filterByRoomType($roomType))
            ->when($isAvailable !== null, fn($q) => $q->available($isAvailable))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific classroom by ID.
     *
     * @param int $id Classroom ID
     * @return ClassRoom Classroom model instance with relationships
     * @throws ModelNotFoundException When classroom is not found
     */
    public function getClassRoomById(int $id): ClassRoom
    {
        return ClassRoom::with(['programs'])->findOrFail($id);
    }

    /**
     * Create a new classroom.
     *
     * @param array $data Classroom data including name, capacity, programs, etc.
     * @return ClassRoom Created classroom instance with program relationships
     * @throws Exception When creation fails
     */
    public function createClassRoom(array $data): ClassRoom
    {
        return DB::transaction(function () use ($data) {
            $classRoom = ClassRoom::query()->create($data);
            $classRoom->programs()->attach($data['programs']);
            return $classRoom->load(['programs']);
        });
    }

    /**
     * Update an existing classroom.
     *
     * @param int $id Classroom ID to update
     * @param array $data Updated classroom data
     * @return ClassRoom Updated classroom instance with program relationships
     * @throws ModelNotFoundException When classroom is not found
     * @throws Exception When update fails
     */
    public function updateClassRoom(int $id, array $data): ClassRoom
    {
        return DB::transaction(function () use ($data, $id) {
            $classRoom = ClassRoom::query()->findOrFail($id);
            $classRoom->programs()->sync($data['programs']);
            $classRoom->update($data);
            return $classRoom;
        });
    }

    /**
     * Delete a classroom (Soft Delete).
     *
     * @param int $id Classroom ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When classroom is not found
     * @throws Exception When deletion fails
     */
    public function deleteClassRoom(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $classRoom = ClassRoom::query()->findOrFail($id);
            $classRoom->programs()->detach();
            $classRoom->delete();
            return true;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Section Relationship Helper Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle the complex many-to-many relationships for sections
    | with programs, semesters, and items. These helper methods manage the
    | intricate relationships between sections and their associated academic
    | entities, ensuring data integrity and proper relationship management.
    |
    */

    /**
     * Bulk update classroom status.
     *
     * @param array $ids Array of classroom IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of classrooms updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateClassRoomStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return ClassRoom::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete classrooms (Soft Delete).
     *
     * @param array $ids Array of classroom IDs to delete
     * @return int Number of classrooms successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteClassRooms(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $classRooms = ClassRoom::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($classRooms as $classRoom) {
                $classRoom->programs()->detach();
                $classRoom->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Enroll Subject Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all enroll subject-related operations including CRUD operations
    | for enroll subjects and enroll subject filtering. Enroll subject management
    | includes creating, updating, deleting, and retrieving enrollment information
    | with support for program, semester, and section associations, as well as
    | comprehensive subject enrollment tracking.
    |
    */

    /**
     * Get a paginated list of enroll subjects with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $programId Filter by program ID
     * @param int|null $semesterId Filter by semester ID
     * @param int|null $sectionId Filter by section ID
     * @param string|null $status Filter by enroll subject status (active/inactive)
     * @param string|null $search Search term for enroll subject
     * @return LengthAwarePaginator Paginated list of enroll subjects
     */
    public function getEnrollSubjects(int $perPage, ?int $programId = null, ?int $semesterId = null, ?int $sectionId = null, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = EnrollSubject::with(['program', 'semester', 'section', 'subjects'])
            ->when($programId, fn($q) => $q->filterByProgram($programId))
            ->when($semesterId, fn($q) => $q->filterBySemester($semesterId))
            ->when($sectionId, fn($q) => $q->filterBySection($sectionId))
            ->when($status, fn($q) => $q->filterByStatus($status));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific enroll subject by ID.
     *
     * @param int $id Enroll subject ID
     * @return EnrollSubject Enroll subject model instance with relationships
     * @throws ModelNotFoundException When enroll subject is not found
     */
    public function getEnrollSubjectById(int $id): EnrollSubject
    {
        return EnrollSubject::with(['program', 'semester', 'section', 'subjects'])->findOrFail($id);
    }

    /**
     * Create a new enroll subject.
     *
     * @param array $data Enroll subject data including program_id, semester_id, section_id, subjects, etc.
     * @return EnrollSubject Created enroll subject instance with relationships
     * @throws Exception When creation fails
     */
    public function createEnrollSubject(array $data): EnrollSubject
    {
        return DB::transaction(function () use ($data) {
            $subjects = $data['subjects'] ?? [];
            unset($data['subjects']);

            $enrollSubject = EnrollSubject::query()->firstOrCreate(
                [
                    'program_id' => $data['program_id'],
                    'semester_id' => $data['semester_id'],
                    'section_id' => $data['section_id'],
                ],
                $data
            );

            $enrollSubject->subjects()->sync($subjects);

            return $enrollSubject->load(['program', 'semester', 'section', 'subjects']);
        });
    }

    /**
     * Update an existing enroll subject.
     *
     * @param int $id Enroll subject ID to update
     * @param array $data Updated enroll subject data
     * @return EnrollSubject Updated enroll subject instance with relationships
     * @throws ModelNotFoundException When enroll subject is not found
     * @throws Exception When update fails
     */
    public function updateEnrollSubject(int $id, array $data): EnrollSubject
    {
        return DB::transaction(function () use ($data, $id) {
            $enrollSubject = EnrollSubject::query()->findOrFail($id);

            $subjects = $data['subjects'] ?? null;
            unset($data['subjects']);

            $enrollSubject->update($data);

            if ($subjects !== null) {
                $enrollSubject->subjects()->sync($subjects);
            }

            return $enrollSubject->load(['program', 'semester', 'section', 'subjects']);
        });
    }

    /**
     * Delete an enroll subject (Soft Delete).
     *
     * @param int $id Enroll subject ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When enroll subject is not found
     * @throws Exception When deletion fails
     */
    public function deleteEnrollSubject(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $enrollSubject = EnrollSubject::query()->findOrFail($id);
            $enrollSubject->subjects()->detach();
            $enrollSubject->delete();
            return true;
        });
    }

    /**
     * Bulk update enroll subject status.
     *
     * @param array $ids Array of enroll subject IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of enroll subjects updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateEnrollSubjectStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return EnrollSubject::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete enroll subjects (Soft Delete).
     *
     * @param array $ids Array of enroll subject IDs to delete
     * @return int Number of enroll subjects successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteEnrollSubjects(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $enrollSubjects = EnrollSubject::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($enrollSubjects as $enrollSubject) {
                $enrollSubject->subjects()->detach();
                $enrollSubject->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }
}
