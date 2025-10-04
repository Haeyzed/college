<?php

namespace App\Services\v1;

use App\Models\v1\Program;
use App\Models\v1\Faculty;
use App\Models\v1\Batch;
use App\Models\v1\Session;
use App\Models\v1\Semester;
use App\Models\v1\Subject;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Program Service - Version 1
 *
 * This service handles all program-related operations including creation,
 * management, and relationship handling in the College Management System.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ProgramService
{
    /**
     * Create a new program.
     *
     * @param array $data
     * @return Program
     * @throws Exception
     */
    public function createProgram(array $data): Program
    {
        try {
            return DB::transaction(function () use ($data) {
                // Validate faculty
                if (!Faculty::where('id', $data['faculty_id'])->where('status', true)->exists()) {
                    throw new Exception('Invalid or inactive faculty selected');
                }

                // Generate slug if not provided
                if (empty($data['slug'])) {
                    $data['slug'] = Str::slug($data['title']);
                }

                // Ensure slug is unique
                $data['slug'] = $this->generateUniqueSlug($data['slug']);

                // Create the program
                $program = Program::create($data);

                return $program;
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to create program: ' . $th->getMessage());
        }
    }

    /**
     * Update an existing program.
     *
     * @param int $id
     * @param array $data
     * @return Program
     * @throws Exception
     */
    public function updateProgram(int $id, array $data): Program
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $program = Program::findOrFail($id);

                // Validate faculty if provided
                if (isset($data['faculty_id'])) {
                    if (!Faculty::where('id', $data['faculty_id'])->where('status', true)->exists()) {
                        throw new Exception('Invalid or inactive faculty selected');
                    }
                }

                // Generate slug if title is updated
                if (isset($data['title']) && empty($data['slug'])) {
                    $data['slug'] = Str::slug($data['title']);
                }

                // Ensure slug is unique if provided
                if (isset($data['slug'])) {
                    $data['slug'] = $this->generateUniqueSlug($data['slug'], $id);
                }

                // Update the program
                $program->update($data);

                return $program->fresh();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to update program: ' . $th->getMessage());
        }
    }

    /**
     * Get program by ID with relationships.
     *
     * @param int $id
     * @return Program
     * @throws Exception
     */
    public function getProgram(int $id): Program
    {
        try {
            return Program::with([
                'faculty',
                'batches',
                'semesters',
                'sessions',
                'subjects',
                'students' => function ($query) {
                    $query->where('status', 1); // Only active students
                }
            ])->findOrFail($id);
        } catch (Throwable $th) {
            throw new Exception('Program not found');
        }
    }

    /**
     * Get paginated programs with filters.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPrograms(Request $request)
    {
        $query = Program::with(['faculty']);

        // Apply filters
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        if ($request->filled('faculty_id')) {
            $query->filterByFaculty($request->faculty_id);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'title');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate results
        $perPage = $request->get('per_page', 15);
        return $query->paginate($perPage);
    }

    /**
     * Delete a program.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteProgram(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $program = Program::findOrFail($id);

                // Check if program has active students
                if ($program->students()->where('status', 1)->exists()) {
                    throw new Exception('Cannot delete program with active students');
                }

                return $program->delete();
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to delete program: ' . $th->getMessage());
        }
    }

    /**
     * Attach batches to program.
     *
     * @param int $programId
     * @param array $batchIds
     * @return Program
     * @throws Exception
     */
    public function attachBatches(int $programId, array $batchIds): Program
    {
        try {
            return DB::transaction(function () use ($programId, $batchIds) {
                $program = Program::findOrFail($programId);

                // Validate batch IDs
                $validBatches = Batch::whereIn('id', $batchIds)
                    ->where('status', true)
                    ->pluck('id')
                    ->toArray();

                if (count($validBatches) !== count($batchIds)) {
                    throw new Exception('One or more invalid or inactive batches selected');
                }

                // Attach batches
                $program->batches()->syncWithoutDetaching($validBatches);

                return $program->fresh(['batches']);
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to attach batches: ' . $th->getMessage());
        }
    }

    /**
     * Detach batches from program.
     *
     * @param int $programId
     * @param array $batchIds
     * @return Program
     * @throws Exception
     */
    public function detachBatches(int $programId, array $batchIds): Program
    {
        try {
            return DB::transaction(function () use ($programId, $batchIds) {
                $program = Program::findOrFail($programId);

                // Detach batches
                $program->batches()->detach($batchIds);

                return $program->fresh(['batches']);
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to detach batches: ' . $th->getMessage());
        }
    }

    /**
     * Attach subjects to program.
     *
     * @param int $programId
     * @param array $subjectIds
     * @return Program
     * @throws Exception
     */
    public function attachSubjects(int $programId, array $subjectIds): Program
    {
        try {
            return DB::transaction(function () use ($programId, $subjectIds) {
                $program = Program::findOrFail($programId);

                // Validate subject IDs
                $validSubjects = Subject::whereIn('id', $subjectIds)
                    ->where('status', true)
                    ->pluck('id')
                    ->toArray();

                if (count($validSubjects) !== count($subjectIds)) {
                    throw new Exception('One or more invalid or inactive subjects selected');
                }

                // Attach subjects
                $program->subjects()->syncWithoutDetaching($validSubjects);

                return $program->fresh(['subjects']);
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to attach subjects: ' . $th->getMessage());
        }
    }

    /**
     * Detach subjects from program.
     *
     * @param int $programId
     * @param array $subjectIds
     * @return Program
     * @throws Exception
     */
    public function detachSubjects(int $programId, array $subjectIds): Program
    {
        try {
            return DB::transaction(function () use ($programId, $subjectIds) {
                $program = Program::findOrFail($programId);

                // Detach subjects
                $program->subjects()->detach($subjectIds);

                return $program->fresh(['subjects']);
            });
        } catch (Throwable $th) {
            throw new Exception('Failed to detach subjects: ' . $th->getMessage());
        }
    }

    /**
     * Get program statistics.
     *
     * @return array
     */
    public function getProgramStatistics(): array
    {
        try {
            $total = Program::count();
            $active = Program::filterByStatus(true)->count();
            $inactive = Program::filterByStatus(false)->count();

            $withStudents = Program::whereHas('students', function ($query) {
                $query->where('status', 1);
            })->count();

            $registrationOpen = Program::where('registration', true)
                ->where('status', true)
                ->count();

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'with_students' => $withStudents,
                'registration_open' => $registrationOpen,
                'active_rate' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
            ];
        } catch (Throwable $th) {
            throw new Exception('Failed to get program statistics: ' . $th->getMessage());
        }
    }

    /**
     * Get programs by faculty.
     *
     * @param int $facultyId
     * @return Collection
     */
    public function getProgramsByFaculty(int $facultyId)
    {
        return Program::filterByFaculty($facultyId)
            ->filterByStatus(true)
            ->orderBy('title')
            ->get();
    }

    /**
     * Generate unique slug.
     *
     * @param string $slug
     * @param int|null $excludeId
     * @return string
     */
    private function generateUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Program::where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
