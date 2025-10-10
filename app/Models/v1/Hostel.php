<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Hostel Model - Version 1
 *
 * Represents a hostel in the College Management System.
 * This model handles hostel information and relationships with rooms.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $capacity
 * @property string $warden_name
 * @property string $warden_contact
 * @property string $address
 * @property string $note
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|HostelRoom[] $rooms
 */
class Hostel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'warden_name',
        'warden_contact',
        'address',
        'note',
        'status',
    ];

    /**
     * Get the rooms for the hostel.
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(HostelRoom::class);
    }

    /**
     * Scope to filter hostels by status.
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
     * Scope to filter hostels by type.
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeFilterByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to search hostels by name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('warden_name', $search);
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
            'capacity' => 'integer',
        ];
    }
}
