<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TransferCredit Model - Version 1
 *
 * Represents a transfer credit in the College Management System.
 * This model handles transfer credit information and relationships with students.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property string $subject_title
 * @property string $subject_code
 * @property int $credit_hours
 * @property float $grade
 * @property string $from_institution
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 */
class TransferCredit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_title',
        'subject_code',
        'credit_hours',
        'grade',
        'from_institution',
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
            'grade' => 'float',
        ];
    }

    /**
     * Get the student that owns the transfer credit.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope to filter transfer credits by student.
     *
     * @param Builder $query
     * @param int $studentId
     * @return Builder
     */
    public function scopeFilterByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
}
