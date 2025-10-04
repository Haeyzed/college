<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property string $title
 * @property string $code
 * @property int $credit_hour
 * @property string $subject_type
 * @property string $class_type
 * @property int $total_marks
 * @property int $passing_marks
 * @property string|null $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|Program[] $programs
 * @property-read Collection|EnrollSubject[] $subjectEnrolls
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|StudentAttendance[] $attendances
 * @property-read Collection|ExamRoutine[] $examRoutines
 * @property-read Collection|Exam[] $exams
 * @property-read Collection|SubjectMarking[] $subjectMarks
 */
class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'code',
        'credit_hour',
        'subject_type',
        'class_type',
        'total_marks',
        'passing_marks',
        'description',
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
            'credit_hour' => 'integer',
            'total_marks' => 'integer',
            'passing_marks' => 'integer',
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
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter subjects by type.
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeFilterByType($query, $type)
    {
        return $query->where('subject_type', $type);
    }

    /**
     * Scope to filter subjects by class type.
     *
     * @param Builder $query
     * @param string $classType
     * @return Builder
     */
    public function scopeFilterByClassType($query, $classType)
    {
        return $query->where('class_type', $classType);
    }

    /**
     * Scope to search subjects by title or code.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('code', $search);
        });
    }
}
