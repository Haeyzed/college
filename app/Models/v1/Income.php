<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Income Model - Version 1
 *
 * Represents an income in the College Management System.
 * This model handles income information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $invoice_id
 * @property float $amount
 * @property string $date
 * @property string $reference
 * @property string $payment_method
 * @property string $note
 * @property string $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read IncomeCategory $category
 * @property-read User $recordedBy
 */
class Income extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'invoice_id',
        'amount',
        'date',
        'reference',
        'payment_method',
        'note',
        'attach',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the income category for the income.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }

    /**
     * Get the user who recorded the income.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter incomes by status.
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
     * Scope to search incomes by title or invoice ID.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('invoice_id', $search);
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'amount' => 'decimal:2',
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
