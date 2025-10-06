<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\v1\Status;
use App\Enums\v1\SubjectType;
use App\Enums\v1\ClassType;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Subject Model - Version 1
 *
 * Represents an academic subject in the College Management System.
 * This model handles subject information, relationships with programs,
 * enrollments, classes, and academic records.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $credit_hours
 * @property string $subject_type
 * @property string $class_type
 * @property float|null $total_marks
 * @property float|null $passing_marks
 * @property string|null $description
 * @property string|null $learning_outcomes
 * @property string|null $prerequisites
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Program[] $programs
 * @property-read Collection|EnrollSubject[] $subjectEnrolls
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|StudentAttendance[] $attendances
 * @property-read Collection|ExamRoutine[] $examRoutines
 * @property-read Collection|Exam[] $exams
 * @property-read Collection|SubjectMarking[] $subjectMarks
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Subject extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'subject_type',
        'class_type',
        'total_marks',
        'passing_marks',
        'description',
        'learning_outcomes',
        'prerequisites',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'credit_hours' => 'integer',
            'total_marks' => 'decimal:2',
            'passing_marks' => 'decimal:2',
            'subject_type' => SubjectType::class,
            'class_type' => ClassType::class,
            'status' => Status::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the programs for the subject.
     *
     * @return BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_subject', 'subject_id', 'program_id');
    }

    /**
     * Get the subject enrollments.
     *
     * @return BelongsToMany
     */
    public function subjectEnrolls(): BelongsToMany
    {
        return $this->belongsToMany(EnrollSubject::class, 'enroll_subject_subject', 'subject_id', 'enroll_subject_id');
    }

    /**
     * Get the student enrollments for the subject.
     *
     * @return BelongsToMany
     */
    public function studentEnrolls(): BelongsToMany
    {
        return $this->belongsToMany(StudentEnroll::class, 'student_enroll_subject', 'student_enroll_id', 'subject_id');
    }

    /**
     * Get the classes for the subject.
     *
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoutine::class);
    }

    /**
     * Get the attendances for the subject.
     *
     * @return HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(StudentAttendance::class);
    }

    /**
     * Get the exam routines for the subject.
     *
     * @return HasMany
     */
    public function examRoutines(): HasMany
    {
        return $this->hasMany(ExamRoutine::class);
    }

    /**
     * Get the exams for the subject.
     *
     * @return HasMany
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Get the subject markings for the subject.
     *
     * @return HasMany
     */
    public function subjectMarks(): HasMany
    {
        return $this->hasMany(SubjectMarking::class);
    }

    /**
     * Scope to filter subjects by status.
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
     * Scope to filter subjects by subject type.
     *
     * @param Builder $query
     * @param string $subjectType
     * @return Builder
     */
    public function scopeFilterBySubjectType(Builder $query, string $subjectType): Builder
    {
        return $query->where('subject_type', $subjectType);
    }

    /**
     * Scope to filter subjects by class type.
     *
     * @param Builder $query
     * @param string $classType
     * @return Builder
     */
    public function scopeFilterByClassType(Builder $query, string $classType): Builder
    {
        return $query->where('class_type', $classType);
    }

    /**
     * Scope to filter subjects by credit hours.
     *
     * @param Builder $query
     * @param int $creditHours
     * @return Builder
     */
    public function scopeFilterByCreditHours(Builder $query, int $creditHours): Builder
    {
        return $query->where('credit_hours', $creditHours);
    }

    /**
     * Scope to filter subjects by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram(Builder $query, int $programId): Builder
    {
        return $query->whereHas('programs', function ($q) use ($programId) {
            $q->where('id', $programId);
        });
    }

    /**
     * Scope to filter subjects by faculty.
     *
     * @param Builder $query
     * @param int $facultyId
     * @return Builder
     */
    public function scopeFilterByFaculty(Builder $query, int $facultyId): Builder
    {
        return $query->whereHas('programs.faculty', function ($q) use ($facultyId) {
            $q->where('id', $facultyId);
        });
    }

    /**
     * Scope to search subjects by name, code, or description.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('code', $search)
                ->orWhereLike('description', $search);
        });
    }
}
