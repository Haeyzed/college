<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * TransportMember Model - Version 1
 *
 * Represents a transport member in the College Management System.
 * This model handles transport member information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $transportable_type
 * @property int $transportable_id
 * @property int $route_id
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model $transportable
 */
class TransportMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transportable_type',
        'transportable_id',
        'route_id',
        'status',
    ];

    /**
     * Get the transportable model.
     *
     * @return MorphTo
     */
    public function transportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter transport members by status.
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
