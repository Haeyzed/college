<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * PostalExchange Model - Version 1
 *
 * Represents a postal exchange in the College Management System.
 * This model handles postal exchange information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $type
 * @property int $category_id
 * @property string $title
 * @property string $reference
 * @property string $from
 * @property string $to
 * @property string $note
 * @property string $date
 * @property string $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read PostalExchangeType $category
 * @property-read User $recordedBy
 */
class PostalExchange extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'category_id',
        'title',
        'reference',
        'from',
        'to',
        'note',
        'date',
        'attach',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the postal exchange type for the postal exchange.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostalExchangeType::class, 'category_id');
    }

    /**
     * Get the user who recorded the postal exchange.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter postal exchanges by status.
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
     * Scope to search postal exchanges by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('reference', $search);
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
            'category_id' => 'integer',
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
