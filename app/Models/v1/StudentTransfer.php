<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StudentTransfer Model - Version 1
 *
 * Represents a student transfer in the College Management System.
 * This model handles transfer information and relationships with students.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property string $from_program
 * @property string $to_program
 * @property string $reason
 * @property Carbon $transfer_date
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 */
class StudentTransfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'from_program',
        'to_program',
        'reason',
        'transfer_date',
        'status',
    ];

    /**
     * Get the student that owns the transfer.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope to filter transfers by status.
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
     * Scope to filter transfers by student.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'transfer_date' => 'datetime',
        ];
    }
}
