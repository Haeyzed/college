<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * HostelMember Model - Version 1
 *
 * Represents a hostel member in the College Management System.
 * This model handles hostel member information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $hostelable_type
 * @property int $hostelable_id
 * @property int $hostel_id
 * @property int $room_id
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model $hostelable
 */
class HostelMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hostelable_type',
        'hostelable_id',
        'hostel_id',
        'room_id',
        'status',
    ];

    /**
     * Get the hostelable model.
     *
     * @return MorphTo
     */
    public function hostelable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter hostel members by status.
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
