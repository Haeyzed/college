<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\v1\BookRequestStatus;

/**
 * BookRequest Model - Version 1
 *
 * This model represents book requests in the library system.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookRequest extends Model
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
        'request_by',
        'phone',
        'email',
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
            'price' => 'decimal:2',
            'quantity' => 'integer',
            'publish_year' => 'integer',
            'status' => BookRequestStatus::class,
        ];
    }

    /**
     * Get the book category that owns the book request.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }
}
