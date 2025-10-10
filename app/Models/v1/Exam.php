<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Exam Model - Version 1
 *
 * Represents an exam in the College Management System.
 * This model handles exam information and relationships with students,
 * subjects, and exam routines.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property int $subject_id
 * @property int $exam_routine_id
 * @property float $marks
 * @property string $grade
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 * @property-read Subject $subject
 * @property-read ExamRoutine $examRoutine
 */
class Exam extends Model
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
        'exam_routine_id',
        'marks',
        'grade',
        'status',
    ];

    /**
     * Get the student that owns the exam.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject that owns the exam.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the exam routine that owns the exam.
     *
     * @return BelongsTo
     */
    public function examRoutine(): BelongsTo
    {
        return $this->belongsTo(ExamRoutine::class);
    }

    /**
     * Scope to filter exams by status.
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
     * Scope to filter exams by student.
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
     * Scope to filter exams by subject.
     *
     * @param Builder $query
     * @param int $subjectId
     * @return Builder
     */
    public function scopeFilterBySubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'marks' => 'float',
        ];
    }
}
