<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Item Model - Version 1
 *
 * Represents an item in the College Management System.
 * This model handles item information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $unit
 * @property string $serial_number
 * @property int $quantity
 * @property string $description
 * @property string $attach
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read ItemCategory $category
 * @property-read Collection|ItemStock[] $stocks
 * @property-read Collection|ItemIssue[] $issues
 */
class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'unit',
        'serial_number',
        'quantity',
        'description',
        'attach',
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
            'category_id' => 'integer',
            'quantity' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the item category for the item.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class, 'category_id');
    }

    /**
     * Get the stocks for the item.
     *
     * @return HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(ItemStock::class, 'item_id');
    }

    /**
     * Get the issues for the item.
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(ItemIssue::class, 'item_id');
    }

    /**
     * Scope to filter items by status.
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
     * Scope to search items by name or serial number.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('serial_number', $search);
        });
    }
}
