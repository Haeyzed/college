<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\v1\MemberType;
use App\Enums\v1\IssueStatus;

/**
 * IssueReturn Model - Version 1
 *
 * Represents a book issue/return transaction in the College Management System.
 * This model handles book issue and return information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $book_id
 * @property int $member_id
 * @property string $member_type
 * @property Carbon $issue_date
 * @property Carbon $due_date
 * @property Carbon|null $return_date
 * @property float|null $fine_amount
 * @property string $status
 * @property string $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Book $book
 * @property-read Model $member
 */
class IssueReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'member_id',
        'member_type',
        'issue_date',
        'due_date',
        'return_date',
        'fine_amount',
        'status',
        'note',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'datetime',
            'due_date' => 'datetime',
            'return_date' => 'datetime',
            'fine_amount' => 'float',
            'member_type' => MemberType::class,
            'status' => IssueStatus::class,
        ];
    }

    /**
     * Get the book that owns the issue return.
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the member that owns the issue return.
     *
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->morphTo('member', 'member_type', 'member_id');
    }

    /**
     * Scope to filter issue returns by status.
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
     * Scope to filter issue returns by book.
     *
     * @param Builder $query
     * @param int $bookId
     * @return Builder
     */
    public function scopeFilterByBook($query, $bookId)
    {
        return $query->where('book_id', $bookId);
    }

    /**
     * Scope to filter overdue books.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', IssueStatus::ISSUED->value);
    }
}
