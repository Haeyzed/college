<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * IncomeCategory Model - Version 1
 *
 * Represents an income category in the College Management System.
 * This model handles income category information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|Income[] $incomes
 */
class IncomeCategory extends Model
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
        'description',
        'status',
    ];

    /**
     * Get the incomes for the income category.
     *
     * @return HasMany
     */
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, 'category_id');
    }

    /**
     * Scope to filter income categories by status.
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
     * Scope to search income categories by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('slug', $search);
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
            'status' => 'boolean',
        ];
    }
}
