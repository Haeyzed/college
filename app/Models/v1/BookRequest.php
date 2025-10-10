<?php

namespace App\Models\v1;

use App\Enums\v1\BookRequestStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Storage;

/**
 * BookRequest Model - Version 1
 *
 * This model represents book requests in the library system.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $book_category_id
 * @property string $title
 * @property string|null $isbn
 * @property string|null $accession_number
 * @property string|null $author
 * @property string|null $publisher
 * @property string|null $edition
 * @property int|null $publish_year
 * @property string|null $language
 * @property float|null $price
 * @property int $quantity
 * @property string $requester_name
 * @property string|null $requester_phone
 * @property string|null $requester_email
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
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class BookRequest extends Model implements Auditable
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
        'requester_name',
        'requester_phone',
        'requester_email',
        'description',
        'note',
        'cover_image_path',
        'status',
    ];

    /**
     * Boot the model.
     * Handle image deletion on force delete.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Handle image deletion on force delete
        static::deleting(function ($bookRequest) {
            if ($bookRequest->isForceDeleting() && $bookRequest->cover_image_path) {
                // Delete the image file when force deleting
                Storage::disk('public')->delete($bookRequest->cover_image_path);
            }
        });
    }

    /**
     * Get the book category that owns the book request.
     *
     * @return BelongsTo
     */
    public function bookCategory(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class);
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
     * Scope to filter book requests by book category.
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
     * Scope to filter book requests by author.
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
                ->orWhereLike('accession_number', $search)
                ->orWhereLike('requester_name', $search)
                ->orWhereLike('requester_phone', $search)
                ->orWhereLike('requester_email', $search);
        });
    }

    /**
     * Scope to filter book requests by requester.
     *
     * @param Builder $query
     * @param string $requesterName
     * @return Builder
     */
    public function scopeFilterByRequester(Builder $query, string $requesterName): Builder
    {
        return $query->where('requester_name', 'like', "%{$requesterName}%");
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
            'publication_year' => 'integer',
            'status' => BookRequestStatus::class,
            'deleted_at' => 'datetime',
        ];
    }
}
