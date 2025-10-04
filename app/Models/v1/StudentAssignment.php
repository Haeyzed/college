<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StudentAssignment Model - Version 1
 *
 * Represents a student assignment submission in the College Management System.
 * This model handles student assignment information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $assignment_id
 * @property int $student_id
 * @property string|null $submission
 * @property float|null $marks
 * @property string $status
 * @property Carbon $submitted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Assignment $assignment
 * @property-read Student $student
 */
class StudentAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission',
        'marks',
        'status',
        'submitted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'marks' => 'float',
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * Get the assignment that owns the student assignment.
     *
     * @return BelongsTo
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student that owns the student assignment.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope to filter student assignments by status.
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
     * Scope to filter student assignments by student.
     *
     * @param Builder $query
     * @param int $studentId
     * @return Builder
     */
    public function scopeFilterByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope to filter student assignments by assignment.
     *
     * @param Builder $query
     * @param int $assignmentId
     * @return Builder
     */
    public function scopeFilterByAssignment($query, $assignmentId)
    {
        return $query->where('assignment_id', $assignmentId);
    }
}
