<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\v1\Status;
use App\Enums\v1\RoomType;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * ClassRoom Model - Version 1
 *
 * Represents a classroom in the College Management System.
 * This model handles classroom information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $floor
 * @property int $capacity
 * @property string $room_type
 * @property string|null $description
 * @property array|null $facilities
 * @property bool $is_available
 * @property string $status
 * @property int $sort_order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Program[] $programs
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|ExamRoutine[] $examRoutines
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class ClassRoom extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'floor',
        'capacity',
        'room_type',
        'description',
        'facilities',
        'is_available',
        'status',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'facilities' => 'array',
            'is_available' => 'boolean',
            'room_type' => RoomType::class,
            'status' => Status::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the programs for the classroom.
     *
     * @return BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_class_room', 'class_room_id', 'program_id');
    }

    /**
     * Get the classes for the classroom.
     *
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoutine::class, 'room_id');
    }

    /**
     * Get the exam routines for the classroom.
     *
     * @return BelongsToMany
     */
    public function examRoutines(): BelongsToMany
    {
        return $this->belongsToMany(ExamRoutine::class, 'exam_routine_room', 'room_id', 'exam_routine_id');
    }

    /**
     * Scope to filter classrooms by status.
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
     * Scope to filter classrooms by room type.
     *
     * @param Builder $query
     * @param string $roomType
     * @return Builder
     */
    public function scopeFilterByRoomType(Builder $query, string $roomType): Builder
    {
        return $query->where('room_type', $roomType);
    }

    /**
     * Scope to filter classrooms by floor.
     *
     * @param Builder $query
     * @param string $floor
     * @return Builder
     */
    public function scopeFilterByFloor(Builder $query, string $floor): Builder
    {
        return $query->where('floor', $floor);
    }

    /**
     * Scope to filter available classrooms.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope to filter classrooms by capacity.
     *
     * @param Builder $query
     * @param int $minCapacity
     * @return Builder
     */
    public function scopeFilterByCapacity(Builder $query, int $minCapacity): Builder
    {
        return $query->where('capacity', '>=', $minCapacity);
    }

    /**
     * Scope to search classrooms by name, code, or description.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('code', $search)
                ->orWhereLike('description', $search);
        });
    }

    /**
     * Scope to order classrooms by sort order.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
