<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ExamRoutine Model - Version 1
 *
 * Represents an exam routine in the College Management System.
 * This model handles exam routine information and relationships with subjects,
 * programs, and exams.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $subject_id
 * @property int $program_id
 * @property string $title
 * @property Carbon $exam_date
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Subject $subject
 * @property-read Program $program
 * @property-read Collection|Exam[] $exams
 */
class ExamRoutine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject_id',
        'program_id',
        'title',
        'exam_date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Get the subject that owns the exam routine.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the program that owns the exam routine.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the exams for the exam routine.
     *
     * @return HasMany
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Scope to filter exam routines by status.
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
     * Scope to filter exam routines by program.
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
     * Scope to filter exam routines by subject.
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
            'exam_date' => 'datetime',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
