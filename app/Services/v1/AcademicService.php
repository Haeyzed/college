<?php

namespace App\Services\v1;

use App\Models\v1\Batch;
use App\Models\v1\ClassRoom;
use App\Models\v1\Faculty;
use App\Models\v1\Program;
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
    | for faculties and faculty filtering.
    |
    */

    /**
     * Get a paginated list of faculties.
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
     */
    public function getFacultyById(int $id): Faculty
    {
        return Faculty::query()->findOrFail($id);
    }

    /**
     * Create a new faculty.
     */
    public function createFaculty(array $data): Faculty
    {
        return DB::transaction(function () use ($data) {
            return Faculty::query()->create($data);
        });
    }

    /**
     * Update a faculty.
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
     */
    public function bulkUpdateFacultyStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Faculty::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete faculties (Soft Delete).
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
    | for programs and program filtering.
    |
    */

    /**
     * Get a paginated list of programs.
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
     */
    public function getProgramById(int $id): Program
    {
        return Program::with(['faculty', 'batches'])->findOrFail($id);
    }

    /**
     * Create a new program.
     */
    public function createProgram(array $data): Program
    {
        return DB::transaction(function () use ($data) {
            $program = Program::query()->create($data);
            return $program->load(['faculty']);
        });
    }

    /**
     * Update a program.
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
     */
    public function bulkUpdateProgramStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Program::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete programs (Soft Delete).
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
    | for batches and batch filtering.
    |
    */

    /**
     * Get a paginated list of batches.
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
     */
    public function getBatchById(int $id): Batch
    {
        return Batch::with(['programs', 'sections'])->findOrFail($id);
    }

    /**
     * Create a new batch.
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
     * Update a batch.
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
     */
    public function bulkUpdateBatchStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Batch::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete batches (Soft Delete).
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
    | for sections and section filtering.
    |
    */

    /**
     * Get a paginated list of sections.
     */
    public function getSections(int $perPage, ?int $batchId = null, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = Section::with(['batch'])
            ->when($batchId, fn($q) => $q->filterByBatch($batchId))
            ->when($status, fn($q) => $q->filterByStatus($status))
            ->when($search, fn($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific section by ID.
     */
    public function getSectionById(int $id): Section
    {
        return Section::with(['batch', 'students'])->findOrFail($id);
    }

    /**
     * Create a new section.
     */
    public function createSection(array $data): Section
    {
        return DB::transaction(function () use ($data) {
            $section = Section::query()->create($data);
            $this->syncSectionRelationships($section, $data);
            return $section->load(['batch', 'programSemesters']);
        });
    }

    /**
     * Update a section.
     */
    public function updateSection(int $id, array $data): Section
    {
        return DB::transaction(function () use ($data, $id) {
            $section = Section::query()->findOrFail($id);
            $section->update($data);
            $this->syncSectionRelationships($section, $data);
            return $section->load(['batch', 'programSemesters']);
        });
    }

    /**
     * Delete a section (Soft Delete).
     */
    public function deleteSection(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $section = Section::query()->findOrFail($id);
            $section->delete();
            return true;
        });
    }

    /**
     * Bulk update section status.
     */
    public function bulkUpdateSectionStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Section::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete sections (Soft Delete).
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

    /*
    |--------------------------------------------------------------------------
    | Semester Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all semester-related operations including CRUD operations
    | for semesters and semester filtering.
    |
    */

    /**
     * Get a paginated list of semesters.
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
     */
    public function getSemesterById(int $id): Semester
    {
        return Semester::query()->findOrFail($id);
    }

    /**
     * Create a new semester.
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
     * Update a semester.
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

    /**
     * Bulk update semester status.
     */
    public function bulkUpdateSemesterStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Semester::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete semesters (Soft Delete).
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

    /*
    |--------------------------------------------------------------------------
    | Subject Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all subject-related operations including CRUD operations
    | for subjects and subject filtering.
    |
    */

    /**
     * Get a paginated list of subjects.
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
     */
    public function getSubjectById(int $id): Subject
    {
        return Subject::with(['programs', 'programs.faculty'])->findOrFail($id);
    }

    /**
     * Create a new subject.
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
     * Update a subject.
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

    /**
     * Bulk update subject status.
     */
    public function bulkUpdateSubjectStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Subject::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete subjects (Soft Delete).
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

    /*
    |--------------------------------------------------------------------------
    | Academic Session Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all academic session-related operations including CRUD operations
    | for academic sessions and academic session filtering.
    |
    */

    /**
     * Get a paginated list of academic sessions.
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
     */
    public function getAcademicSessionById(int $id): Session
    {
        return Session::with(['programs'])->findOrFail($id);
    }

    /**
     * Create a new academic session.
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
     * Update an academic session.
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
     */
    public function bulkUpdateAcademicSessionStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Session::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete academic sessions (Soft Delete).
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
     * @param int $id The ID of the session to set as current.
     * @return Session
     * @throws ModelNotFoundException
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

    /*
    |--------------------------------------------------------------------------
    | ClassRoom Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all classroom-related operations including CRUD operations
    | for classrooms and classroom filtering.
    |
    */

    /**
     * Get a paginated list of classrooms.
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
     */
    public function getClassRoomById(int $id): ClassRoom
    {
        return ClassRoom::with(['programs'])->findOrFail($id);
    }

    /**
     * Create a new classroom.
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
     * Update a classroom.
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

    /**
     * Bulk update classroom status.
     */
    public function bulkUpdateClassRoomStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return ClassRoom::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete classrooms (Soft Delete).
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
    | Section Relationship Helper Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle the complex many-to-many relationships for sections
    | with programs, semesters, and items.
    |
    */

    /**
     * Sync section relationships with programs, semesters, and subjects.
     *
     * @param Section $section
     * @param array $data
     * @return void
     */
    private function syncSectionRelationships(Section $section, array $data): void
    {
        if (!isset($data['programs']) || !isset($data['semesters']) || !isset($data['items'])) {
            return;
        }

        // Delete existing relationships
        $section->programSemesters()->delete();

        // Create new relationships
        $programs = $data['programs'];
        $semesters = $data['semesters'];
        $items = $data['items'];

        foreach ($items as $index => $item) {
            if (isset($programs[$index]) && isset($semesters[$index])) {
                \App\Models\v1\ProgramSemesterSection::create([
                    'program_id' => $programs[$index],
                    'semester_id' => $semesters[$index],
                    'section_id' => $section->id,
                ]);
            }
        }
    }
}
