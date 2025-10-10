<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * HostelRoomType Model - Version 1
 *
 * Represents a hostel room type in the College Management System.
 * This model handles hostel room type information and relationships.
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
 * @property-read Collection|HostelRoom[] $rooms
 */
class HostelRoomType extends Model
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
     * Get the rooms for the hostel room type.
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(HostelRoom::class, 'room_type_id');
    }

    /**
     * Scope to filter hostel room types by status.
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
     * Scope to search hostel room types by title.
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
