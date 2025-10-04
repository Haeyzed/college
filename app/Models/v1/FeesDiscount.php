<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * FeesDiscount Model - Version 1
 *
 * Represents a fees discount in the College Management System.
 * This model handles fees discount information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $start_date
 * @property string $end_date
 * @property float $amount
 * @property string $type
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|FeesCategory[] $feesCategories
 * @property-read Collection|StatusType[] $statusTypes
 */
class FeesDiscount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'amount',
        'type',
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
            'amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the fees categories for the fees discount.
     *
     * @return BelongsToMany
     */
    public function feesCategories(): BelongsToMany
    {
        return $this->belongsToMany(FeesCategory::class, 'fees_category_fees_discount', 'fees_discount_id', 'fees_category_id');
    }

    /**
     * Get the status types for the fees discount.
     *
     * @return BelongsToMany
     */
    public function statusTypes(): BelongsToMany
    {
        return $this->belongsToMany(StatusType::class, 'fees_discount_status_type', 'fees_discount_id', 'status_type_id');
    }

    /**
     * Check if the student is eligible for the discount based on their statuses.
     *
     * @param int $discount
     * @param int $student
     * @return bool
     */
    public static function availability($discount, $student): bool
    {
        $discount_type = static::where('id', $discount)
            ->where('status', true)->first();

        if (!$discount_type) {
            return false;
        }

        foreach ($discount_type->statusTypes as $statusType) {
            $availability = Student::where('id', $student)->with('statuses')->whereHas('statuses', function ($query) use ($statusType) {
                $query->where('status_type_id', $statusType->id);
            })->first();

            if ($availability == true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Scope to filter fees discounts by status.
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
     * Scope to search fees discounts by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereLike('title', $search);
    }
}
