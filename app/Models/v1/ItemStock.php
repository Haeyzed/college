<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ItemStock Model - Version 1
 *
 * Represents an item stock in the College Management System.
 * This model handles item stock information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $item_id
 * @property int $supplier_id
 * @property int $store_id
 * @property int $quantity
 * @property float $price
 * @property string $date
 * @property string $reference
 * @property string $payment_method
 * @property string $description
 * @property string $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Item $item
 * @property-read ItemSupplier $supplier
 * @property-read ItemStore $store
 */
class ItemStock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'supplier_id',
        'store_id',
        'quantity',
        'price',
        'date',
        'reference',
        'payment_method',
        'description',
        'attach',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the item for the item stock.
     *
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    /**
     * Get the supplier for the item stock.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(ItemSupplier::class, 'supplier_id');
    }

    /**
     * Get the store for the item stock.
     *
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(ItemStore::class, 'store_id');
    }

    /**
     * Scope to filter item stocks by status.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'item_id' => 'integer',
            'supplier_id' => 'integer',
            'store_id' => 'integer',
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
