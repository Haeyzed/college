<?php

namespace App\Models\v1;

use App\Enums\v1\BookCategoryStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * BookCategory Model - Version 2.0.0
 *
 * Represents a book category in the College Management System.
 * This model implements soft deletes and handles category information.
 *
 * @package App\Models\v1
 * @version 2.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $code
 * @property string|null $description
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Book[] $books
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class BookCategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'code',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Boot the model.
     * Generates slug before creation/update.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->title);
        });

        static::updating(function ($category) {
            // Only update slug if title has changed
            if ($category->isDirty('title')) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    /**
     * Get the books for the category.
     *
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Scope to filter book categories by status.
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
     * Scope to search book categories by title or code.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('code', $search); // Searching by new 'code' field
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => BookCategoryStatus::class,
            'deleted_at' => 'datetime',
        ];
    }
}
