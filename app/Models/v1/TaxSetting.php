<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * TaxSetting Model - Version 1
 *
 * Represents a tax setting in the College Management System.
 * This model handles tax setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property float $min_amount
 * @property float $max_amount
 * @property float $percentange
 * @property float $max_no_taxable_amount
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TaxSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'min_amount',
        'max_amount',
        'percentange',
        'max_no_taxable_amount',
        'status',
    ];

    /**
     * Scope to filter tax settings by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to search tax settings by amount ranges.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('min_amount', 'like', "%{$search}%")
                ->orWhere('max_amount', 'like', "%{$search}%")
                ->orWhere('percentange', 'like', "%{$search}%")
                ->orWhere('max_no_taxable_amount', 'like', "%{$search}%");
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
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
            'percentange' => 'decimal:2',
            'max_no_taxable_amount' => 'decimal:2',
            'status' => 'boolean',
        ];
    }
}
