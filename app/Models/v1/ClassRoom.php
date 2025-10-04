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
 * @property string $title
 * @property string $slug
 * @property int $floor
 * @property int $capacity
 * @property string $type
 * @property string $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|Program[] $programs
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|ExamRoutine[] $examRoutines
 */
class ClassRoom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'floor',
        'capacity',
        'type',
        'description',
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
            'floor' => 'integer',
            'capacity' => 'integer',
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
     * Scope to filter classrooms by type.
     *
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeFilterByType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter classrooms by floor.
     *
     * @param Builder $query
     * @param int $floor
     * @return Builder
     */
    public function scopeFilterByFloor(Builder $query, int $floor): Builder
    {
        return $query->where('floor', $floor);
    }

    /**
     * Scope to search classrooms by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('slug', $search);
        });
    }
}
