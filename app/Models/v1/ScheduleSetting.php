<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * ScheduleSetting Model - Version 1
 *
 * Represents a schedule setting in the College Management System.
 * This model handles schedule setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $slug
 * @property string $day
 * @property string $time
 * @property bool $email
 * @property bool $sms
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ScheduleSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'day',
        'time',
        'email',
        'sms',
        'status',
    ];

    /**
     * Scope to filter schedule settings by status.
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
     * Scope to search schedule settings by slug, day, or time.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('slug', $search)
                ->orWhereLike('day', $search)
                ->orWhereLike('time', $search);
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
            'email' => 'boolean',
            'sms' => 'boolean',
            'status' => 'boolean',
        ];
    }
}
