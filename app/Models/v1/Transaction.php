<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Transaction Model - Version 1
 *
 * Represents a transaction in the College Management System.
 * This model handles transaction information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $transactionable_type
 * @property int $transactionable_id
 * @property string $type
 * @property float $amount
 * @property string $status
 * @property string $reference
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model $transactionable
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transactionable_type',
        'transactionable_id',
        'type',
        'amount',
        'status',
        'reference',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }

    /**
     * Get the transactionable model.
     *
     * @return MorphTo
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter transactions by status.
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
     * Scope to filter transactions by type.
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeFilterByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
