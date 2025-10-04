<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\v1\BookStatus;

/**
 * Book Model - Version 1
 *
 * Represents a book in the College Management System.
 * This model handles book information and relationships with categories and issues.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $isbn
 * @property string $code
 * @property string $author
 * @property string $publisher
 * @property string $edition
 * @property int $publish_year
 * @property string $language
 * @property float $price
 * @property int $quantity
 * @property string $section
 * @property string $column
 * @property string $row
 * @property string $description
 * @property string $note
 * @property string|null $attach
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read BookCategory $category
 * @property-read Collection|IssueReturn[] $issues
 */
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'isbn',
        'code',
        'author',
        'publisher',
        'edition',
        'publish_year',
        'language',
        'price',
        'quantity',
        'section',
        'column',
        'row',
        'description',
        'note',
        'image',
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
            'publish_year' => 'integer',
            'price' => 'float',
            'quantity' => 'integer',
            'status' => BookStatus::class,
        ];
    }

    /**
     * Get the category that owns the book.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
    }

    /**
     * Get the issues for the book.
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(IssueReturn::class);
    }

    /**
     * Scope to filter books by status.
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
     * Scope to filter books by category.
     *
     * @param Builder $query
     * @param int $categoryId
     * @return Builder
     */
    public function scopeFilterByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to filter books by author.
     *
     * @param Builder $query
     * @param string $author
     * @return Builder
     */
    public function scopeFilterByAuthor(Builder $query, string $author): Builder
    {
        return $query->where('author', $author);
    }

    /**
     * Scope to search books by title, author, or ISBN.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('author', $search)
                ->orWhereLike('isbn', $search)
                ->orWhereLike('code', $search);
        });
    }
}
