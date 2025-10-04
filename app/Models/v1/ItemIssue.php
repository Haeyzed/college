<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ItemIssue Model - Version 1
 *
 * Represents an item issue in the College Management System.
 * This model handles item issue information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $item_id
 * @property int $user_id
 * @property int $quantity
 * @property string $issue_date
 * @property string $due_date
 * @property string $return_date
 * @property float $penalty
 * @property string $note
 * @property string $attach
 * @property string $status
 * @property int $issued_by
 * @property int $received_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Item $item
 * @property-read User $user
 * @property-read User $issuedBy
 * @property-read User $receivedBy
 */
class ItemIssue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'user_id',
        'quantity',
        'issue_date',
        'due_date',
        'return_date',
        'penalty',
        'note',
        'attach',
        'status',
        'issued_by',
        'received_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'item_id' => 'integer',
            'user_id' => 'integer',
            'quantity' => 'integer',
            'issue_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
            'penalty' => 'decimal:2',
            'issued_by' => 'integer',
            'received_by' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the item for the item issue.
     *
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    /**
     * Get the user for the item issue.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who issued the item.
     *
     * @return BelongsTo
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Get the user who received the item.
     *
     * @return BelongsTo
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Scope to filter item issues by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
