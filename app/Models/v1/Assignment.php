<?php

namespace App\Models\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Assignment Model - Version 1
 *
 * Represents an assignment in the College Management System.
 * This model handles assignment information and relationships with academic entities.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $program_id
 * @property int $session_id
 * @property int $semester_id
 * @property int $section_id
 * @property int $subject_id
 * @property string $title
 * @property string $description
 * @property float $total_marks
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string|null $attach
 * @property string $status
 * @property int $assign_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Program $program
 * @property-read Session $session
 * @property-read Semester $semester
 * @property-read Section $section
 * @property-read Subject $subject
 * @property-read User $teacher
 * @property-read Collection|StudentAssignment[] $students
 */
class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'program_id',
        'session_id',
        'semester_id',
        'section_id',
        'subject_id',
        'title',
        'description',
        'total_marks',
        'start_date',
        'end_date',
        'attach',
        'status',
        'assign_by',
    ];

    /**
     * Get the faculty that owns the assignment.
     *
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the program that owns the assignment.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the session that owns the assignment.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the semester that owns the assignment.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the section that owns the assignment.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the subject that owns the assignment.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher that owns the assignment.
     *
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_by');
    }

    /**
     * Get the student assignments for the assignment.
     *
     * @return HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(StudentAssignment::class);
    }

    /**
     * Scope to filter assignments by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter assignments by faculty.
     *
     * @param Builder $query
     * @param int $facultyId
     * @return Builder
     */
    public function scopeFilterByFaculty(Builder $query, int $facultyId): Builder
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope to filter assignments by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram(Builder $query, int $programId): Builder
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter assignments by session.
     *
     * @param Builder $query
     * @param int $sessionId
     * @return Builder
     */
    public function scopeFilterBySession(Builder $query, int $sessionId): Builder
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope to filter assignments by semester.
     *
     * @param Builder $query
     * @param int $semesterId
     * @return Builder
     */
    public function scopeFilterBySemester(Builder $query, int $semesterId): Builder
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Scope to filter assignments by section.
     *
     * @param Builder $query
     * @param int $sectionId
     * @return Builder
     */
    public function scopeFilterBySection(Builder $query, int $sectionId): Builder
    {
        return $query->where('section_id', $sectionId);
    }

    /**
     * Scope to filter assignments by subject.
     *
     * @param Builder $query
     * @param int $subjectId
     * @return Builder
     */
    public function scopeFilterBySubject(Builder $query, int $subjectId): Builder
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * Scope to filter assignments by teacher.
     *
     * @param Builder $query
     * @param int $teacherId
     * @return Builder
     */
    public function scopeFilterByTeacher(Builder $query, int $teacherId): Builder
    {
        return $query->where('assign_by', $teacherId);
    }

    /**
     * Scope to filter assignments by date range.
     *
     * @param Builder $query
     * @param string $startDate
     * @param string|null $endDate
     * @return Builder
     */
    public function scopeFilterByDateRange(Builder $query, string $startDate, ?string $endDate = null): Builder
    {
        $query->whereDate('start_date', '>=', $startDate);

        if ($endDate) {
            $query->whereDate('end_date', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Scope to filter assignments by start date.
     *
     * @param Builder $query
     * @param string $startDate
     * @return Builder
     */
    public function scopeFilterByStartDate(Builder $query, string $startDate): Builder
    {
        return $query->whereDate('start_date', '>=', $startDate);
    }

    /**
     * Scope to filter assignments by end date.
     *
     * @param Builder $query
     * @param string $endDate
     * @return Builder
     */
    public function scopeFilterByEndDate(Builder $query, string $endDate): Builder
    {
        return $query->whereDate('end_date', '<=', $endDate);
    }

    /**
     * Scope to filter assignments that are currently active.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter assignments that are currently running.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCurrentlyRunning(Builder $query): Builder
    {
        $today = now()->format('Y-m-d');
        return $query->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'active');
    }

    /**
     * Scope to filter assignments that are overdue.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOverdue(Builder $query): Builder
    {
        $today = now()->format('Y-m-d');
        return $query->where('end_date', '<', $today)
            ->where('status', 'active');
    }

    /**
     * Scope to filter assignments that are upcoming.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        $today = now()->format('Y-m-d');
        return $query->where('start_date', '>', $today)
            ->where('status', 'active');
    }

    /**
     * Scope to search assignments by title, description, or subject.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('description', $search)
                ->orWhereHas('subject', function ($subjectQuery) use ($search) {
                    $subjectQuery->whereLike('title', $search)
                        ->orWhereLike('code', $search);
                });
        });
    }

    /**
     * Scope to filter assignments by multiple criteria.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function scopeFilterBy(Builder $query, array $filters): Builder
    {
        return $query->when(isset($filters['faculty_id']), fn($q) => $q->filterByFaculty($filters['faculty_id']))
            ->when(isset($filters['program_id']), fn($q) => $q->filterByProgram($filters['program_id']))
            ->when(isset($filters['session_id']), fn($q) => $q->filterBySession($filters['session_id']))
            ->when(isset($filters['semester_id']), fn($q) => $q->filterBySemester($filters['semester_id']))
            ->when(isset($filters['section_id']), fn($q) => $q->filterBySection($filters['section_id']))
            ->when(isset($filters['subject_id']), fn($q) => $q->filterBySubject($filters['subject_id']))
            ->when(isset($filters['teacher_id']), fn($q) => $q->filterByTeacher($filters['teacher_id']))
            ->when(isset($filters['status']), fn($q) => $q->filterByStatus($filters['status']))
            ->when(isset($filters['start_date']), fn($q) => $q->filterByStartDate($filters['start_date']))
            ->when(isset($filters['end_date']), fn($q) => $q->filterByEndDate($filters['end_date']))
            ->when(isset($filters['search']), fn($q) => $q->search($filters['search']));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_marks' => 'float',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}
