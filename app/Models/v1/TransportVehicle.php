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
 * TransportVehicle Model - Version 1
 *
 * Represents a transport vehicle in the College Management System.
 * This model handles transport vehicle information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $number
 * @property string $type
 * @property string $model
 * @property int $capacity
 * @property int $year_made
 * @property string $driver_name
 * @property string $driver_license
 * @property string $driver_contact
 * @property string $note
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|TransportRoute[] $transportRoutes
 * @property-read Collection|TransportMember[] $transportMembers
 */
class TransportVehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'type',
        'model',
        'capacity',
        'year_made',
        'driver_name',
        'driver_license',
        'driver_contact',
        'note',
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
            'capacity' => 'integer',
            'year_made' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the transport routes for the transport vehicle.
     *
     * @return BelongsToMany
     */
    public function transportRoutes(): BelongsToMany
    {
        return $this->belongsToMany(TransportRoute::class, 'transport_route_transport_vehicle', 'transport_vehicle_id', 'transport_route_id');
    }

    /**
     * Get the transport members for the transport vehicle.
     *
     * @return HasMany
     */
    public function transportMembers(): HasMany
    {
        return $this->hasMany(TransportMember::class, 'transport_vehicle_id');
    }

    /**
     * Scope to filter transport vehicles by status.
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
     * Scope to search transport vehicles by number or driver name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('number', $search)
                ->orWhereLike('driver_name', $search);
        });
    }
}
