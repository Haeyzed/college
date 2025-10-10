<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * TransportRoute Model - Version 1
 *
 * Represents a transport route in the College Management System.
 * This model handles transport route information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property float $fee
 * @property string $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|TransportVehicle[] $vehicles
 * @property-read Collection|TransportMember[] $transportMembers
 */
class TransportRoute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'fee',
        'description',
        'status',
    ];

    /**
     * Get the vehicles for the transport route.
     *
     * @return BelongsToMany
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(TransportVehicle::class, 'transport_route_transport_vehicle', 'transport_route_id', 'transport_vehicle_id');
    }

    /**
     * Get the transport members for the transport route.
     *
     * @return HasMany
     */
    public function transportMembers(): HasMany
    {
        return $this->hasMany(TransportMember::class, 'transport_route_id');
    }

    /**
     * Scope to filter transport routes by status.
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
     * Scope to search transport routes by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereLike('title', $search);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fee' => 'decimal:2',
            'status' => 'boolean',
        ];
    }
}
