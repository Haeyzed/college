<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * HostelRoom Model - Version 1
 *
 * Represents a hostel room in the College Management System.
 * This model handles hostel room information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $hostel_id
 * @property string $room_no
 * @property string $room_type
 * @property int $capacity
 * @property float $rent
 * @property string $status
 * @property string $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Hostel $hostel
 */
class HostelRoom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hostel_id',
        'room_no',
        'room_type',
        'capacity',
        'rent',
        'status',
        'note',
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
            'rent' => 'float',
        ];
    }

    /**
     * Get the hostel that owns the room.
     *
     * @return BelongsTo
     */
    public function hostel(): BelongsTo
    {
        return $this->belongsTo(Hostel::class);
    }

    /**
     * Scope to filter rooms by status.
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
     * Scope to filter rooms by hostel.
     *
     * @param Builder $query
     * @param int $hostelId
     * @return Builder
     */
    public function scopeFilterByHostel($query, $hostelId)
    {
        return $query->where('hostel_id', $hostelId);
    }

    /**
     * Scope to filter rooms by type.
     *
     * @param Builder $query
     * @param string $roomType
     * @return Builder
     */
    public function scopeFilterByRoomType($query, $roomType)
    {
        return $query->where('room_type', $roomType);
    }

    /**
     * Scope to search rooms by room number.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereLike('room_no', $search);
    }
}
