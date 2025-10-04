<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fee Model - Version 1
 *
 * Represents a fee in the College Management System.
 * This model handles fee information and relationships with student enrollments and categories.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_enroll_id
 * @property int $category_id
 * @property float $fee_amount
 * @property float $fine_amount
 * @property float $discount_amount
 * @property float $paid_amount
 * @property Carbon $assign_date
 * @property Carbon $due_date
 * @property Carbon|null $pay_date
 * @property string $payment_method
 * @property string $note
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read StudentEnroll $studentEnroll
 * @property-read FeesCategory $category
 */
class Fee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_enroll_id',
        'category_id',
        'fee_amount',
        'fine_amount',
        'discount_amount',
        'paid_amount',
        'assign_date',
        'due_date',
        'pay_date',
        'payment_method',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fee_amount' => 'float',
            'fine_amount' => 'float',
            'discount_amount' => 'float',
            'paid_amount' => 'float',
            'assign_date' => 'datetime',
            'due_date' => 'datetime',
            'pay_date' => 'datetime',
        ];
    }

    /**
     * Get the student enrollment that owns the fee.
     *
     * @return BelongsTo
     */
    public function studentEnroll(): BelongsTo
    {
        return $this->belongsTo(StudentEnroll::class);
    }

    /**
     * Get the category that owns the fee.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }

    /**
     * Scope to filter fees by status.
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
     * Scope to filter fees by student enrollment.
     *
     * @param Builder $query
     * @param int $studentEnrollId
     * @return Builder
     */
    public function scopeFilterByStudentEnroll($query, $studentEnrollId)
    {
        return $query->where('student_enroll_id', $studentEnrollId);
    }

    /**
     * Scope to filter overdue fees.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', 'unpaid');
    }

    /**
     * Scope to filter paid fees.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope to filter unpaid fees.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }
}
