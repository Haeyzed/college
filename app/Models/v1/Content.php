<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Content Model - Version 1
 *
 * Represents content in the College Management System.
 * This model handles content information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $program_id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Program $program
 */
class Content extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'title',
        'content',
        'type',
        'status',
    ];

    /**
     * Get the program that owns the content.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Scope to filter content by status.
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
     * Scope to filter content by type.
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
     * Scope to filter content by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram(Builder $query, int $programId): Builder
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to search content by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('content', $search);
        });
    }
}
