<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ResultContribution Model - Version 1
 *
 * Represents a result contribution in the College Management System.
 * This model handles result contribution information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property float $attendances
 * @property float $assignments
 * @property float $activities
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ResultContribution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attendances',
        'assignments',
        'activities',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attendances' => 'decimal:2',
            'assignments' => 'decimal:2',
            'activities' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    /**
     * Scope to filter result contributions by status.
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
