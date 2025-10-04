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
 * Payroll Model - Version 1
 *
 * Represents a payroll in the College Management System.
 * This model handles payroll information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $user_id
 * @property float $basic_salary
 * @property string $salary_type
 * @property float $total_earning
 * @property float $total_allowance
 * @property float $bonus
 * @property float $total_deduction
 * @property float $gross_salary
 * @property float $tax
 * @property float $net_salary
 * @property string $salary_month
 * @property string $pay_date
 * @property string $payment_method
 * @property string $note
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Collection|PayrollDetail[] $details
 */
class Payroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'basic_salary',
        'salary_type',
        'total_earning',
        'total_allowance',
        'bonus',
        'total_deduction',
        'gross_salary',
        'tax',
        'net_salary',
        'salary_month',
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
            'user_id' => 'integer',
            'basic_salary' => 'decimal:2',
            'total_earning' => 'decimal:2',
            'total_allowance' => 'decimal:2',
            'bonus' => 'decimal:2',
            'total_deduction' => 'decimal:2',
            'gross_salary' => 'decimal:2',
            'tax' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'pay_date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the user for the payroll.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the details for the payroll.
     *
     * @return HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(PayrollDetail::class, 'payroll_id');
    }

    /**
     * Scope to filter payrolls by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
