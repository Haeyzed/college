<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * SubjectMarking Model - Version 1
 *
 * Represents a subject marking in the College Management System.
 * This model handles subject marking information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_enroll_id
 * @property int $subject_id
 * @property float $exam_marks
 * @property int $attendances
 * @property float $assignments
 * @property float $activities
 * @property float $total_marks
 * @property string $publish_date
 * @property string $publish_time
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read StudentEnroll $studentEnroll
 * @property-read Subject $subject
 */
class SubjectMarking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_enroll_id',
        'subject_id',
        'exam_marks',
        'attendances',
        'assignments',
        'activities',
        'total_marks',
        'publish_date',
        'publish_time',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the student enroll for the subject marking.
     *
     * @return BelongsTo
     */
    public function studentEnroll(): BelongsTo
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }

    /**
     * Get the subject for the subject marking.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Scope to filter subject markings by status.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'student_enroll_id' => 'integer',
            'subject_id' => 'integer',
            'exam_marks' => 'decimal:2',
            'attendances' => 'integer',
            'assignments' => 'decimal:2',
            'activities' => 'decimal:2',
            'total_marks' => 'decimal:2',
            'publish_date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
