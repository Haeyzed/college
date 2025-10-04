<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * StudentEnroll Model - Version 1
 *
 * Represents a student enrollment in the College Management System.
 * This model handles enrollment information and relationships with students,
 * programs, sessions, semesters, and subjects.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property int $program_id
 * @property int $session_id
 * @property int $semester_id
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 * @property-read Program $program
 * @property-read Session $session
 * @property-read Semester $semester
 * @property-read Collection|Subject[] $subjects
 */
class StudentEnroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'program_id',
        'session_id',
        'semester_id',
        'status',
    ];

    /**
     * Get the student that owns the enrollment.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the program that owns the enrollment.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the session that owns the enrollment.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the semester that owns the enrollment.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the subjects for the enrollment.
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'student_enroll_subject', 'student_enroll_id', 'subject_id');
    }

    /**
     * Scope to filter enrollments by status.
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
     * Scope to filter enrollments by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter enrollments by session.
     *
     * @param Builder $query
     * @param int $sessionId
     * @return Builder
     */
    public function scopeFilterBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope to filter enrollments by semester.
     *
     * @param Builder $query
     * @param int $semesterId
     * @return Builder
     */
    public function scopeFilterBySemester($query, $semesterId)
    {
        return $query->where('semester_id', $semesterId);
    }
}
