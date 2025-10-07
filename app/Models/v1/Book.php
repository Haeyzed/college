<?php

namespace App\Models\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\v1\BookStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Book Model - Version 2.0.0
 *
 * Represents a book in the College Management System.
 * This model handles book information and relationships with categories and issues,
 * and implements soft deletes.
 *
 * @package App\Models\v1
 * @version 2.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $isbn
 * @property string|null $accession_number
 * @property string $author
 * @property string|null $publisher
 * @property string|null $edition
 * @property int|null $publication_year
 * @property string|null $language
 * @property float $price
 * @property int $quantity
 * @property string|null $shelf_location
 * @property string|null $shelf_column
 * @property string|null $shelf_row
 * @property string|null $description
 * @property string|null $note
 * @property string|null $cover_image_path
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read BookCategory $bookCategory
 * @property-read User|null $creator
 * @property-read User|null $editor
 * @property-read Collection|IssueReturn[] $issues
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Book extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_category_id',
        'title',
        'isbn',
        'accession_number',
        'author',
        'publisher',
        'edition',
        'publication_year',
        'language',
        'price',
        'quantity',
        'shelf_location',
        'shelf_column',
        'shelf_row',
        'description',
        'note',
        'cover_image_path',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'price' => 'float',
            'quantity' => 'integer',
            'status' => BookStatus::class,
        ];
    }

    /**
     * Get the book category that owns the book.
     *
     * @return BelongsTo
     */
    public function bookCategory(): BelongsTo
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
     * Scope to filter books by book category.
     *
     * @param Builder $query
     * @param int $bookCategoryId
     * @return Builder
     */
    public function scopeFilterByBookCategory(Builder $query, int $bookCategoryId): Builder
    {
        return $query->where('book_category_id', $bookCategoryId);
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
     * Scope to search books by title, author, ISBN, or Accession Number.
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
                ->orWhereLike('accession_number', $search);
        });
    }

    /**
     * Scope to filter books by availability (quantity > 0).
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope to filter books by availability status.
     *
     * @param Builder $query
     * @param bool $available
     * @return Builder
     */
    public function scopeFilterByAvailability(Builder $query, bool $available): Builder
    {
        return $available 
            ? $query->where('quantity', '>', 0)
            : $query->where('quantity', '<=', 0);
    }

    /**
     * Boot the model.
     * Handle image deletion on force delete.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Handle image deletion on force delete
        static::deleting(function ($book) {
            if ($book->isForceDeleting() && $book->cover_image_path) {
                // Delete the image file when force deleting
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image_path);
            }
        });
    }
}
