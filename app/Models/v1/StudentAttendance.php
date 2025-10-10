<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StudentAttendance Model - Version 1
 *
 * Represents student attendance in the College Management System.
 * This model handles student attendance information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property int $subject_id
 * @property int $session_id
 * @property int $semester_id
 * @property Carbon $attendance_date
 * @property string $status
 * @property string $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 * @property-read Subject $subject
 * @property-read Session $session
 * @property-read Semester $semester
 */
class StudentAttendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_id',
        'session_id',
        'semester_id',
        'attendance_date',
        'status',
        'note',
    ];

    /**
     * Get the student that owns the attendance.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject that owns the attendance.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the session that owns the attendance.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the semester that owns the attendance.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Scope to filter attendance by status.
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
     * Scope to filter attendance by student.
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
     * Scope to filter attendance by date range.
     *
     * @param Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return Builder
     */
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('attendance_date', [$startDate, $endDate]);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attendance_date' => 'datetime',
        ];
    }
}
