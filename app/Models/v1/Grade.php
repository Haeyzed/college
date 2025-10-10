<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Grade Model - Version 1
 *
 * Represents a grade in the College Management System.
 * This model handles grade information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property float $point
 * @property int $min_mark
 * @property int $max_mark
 * @property string $remark
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'point',
        'min_mark',
        'max_mark',
        'remark',
        'status',
    ];

    /**
     * Scope to filter grades by status.
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
     * Scope to search grades by title.
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
            'point' => 'decimal:2',
            'min_mark' => 'integer',
            'max_mark' => 'integer',
            'status' => 'boolean',
        ];
    }
}
