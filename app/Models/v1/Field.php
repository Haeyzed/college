<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Field Model - Version 1
 *
 * Represents a field in the College Management System.
 * This model handles field information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $slug
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'status',
    ];

    /**
     * Get a field by slug.
     *
     * @param string $slug
     * @return Field|null
     */
    public static function field($slug): ?Field
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Scope to filter fields by status.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
