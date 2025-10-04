<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Note Model - Version 1
 *
 * Represents a note in the College Management System.
 * This model handles note information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $noteable_type
 * @property int $noteable_id
 * @property string $title
 * @property string $content
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model $noteable
 */
class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'noteable_type',
        'noteable_id',
        'title',
        'content',
        'status',
    ];

    /**
     * Get the noteable model.
     *
     * @return MorphTo
     */
    public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter notes by status.
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
     * Scope to search notes by title or content.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('content', $search);
        });
    }
}
