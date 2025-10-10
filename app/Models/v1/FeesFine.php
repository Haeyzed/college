<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * FeesFine Model - Version 1
 *
 * Represents a fees fine in the College Management System.
 * This model handles fees fine information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $start_day
 * @property int $end_day
 * @property float $amount
 * @property string $type
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|FeesCategory[] $feesCategories
 */
class FeesFine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_day',
        'end_day',
        'amount',
        'type',
        'status',
    ];

    /**
     * Get the fees categories for the fees fine.
     *
     * @return BelongsToMany
     */
    public function feesCategories(): BelongsToMany
    {
        return $this->belongsToMany(FeesCategory::class, 'fees_category_fees_fine', 'fees_fine_id', 'fees_category_id');
    }

    /**
     * Scope to filter fees fines by status.
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
            'start_day' => 'integer',
            'end_day' => 'integer',
            'amount' => 'decimal:2',
            'status' => 'boolean',
        ];
    }
}
