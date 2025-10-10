<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * ItemSupplier Model - Version 1
 *
 * Represents an item supplier in the College Management System.
 * This model handles item supplier information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $contact_person
 * @property string $designation
 * @property string $contact_person_email
 * @property string $contact_person_phone
 * @property string $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|ItemStock[] $stocks
 */
class ItemSupplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'email',
        'phone',
        'address',
        'contact_person',
        'designation',
        'contact_person_email',
        'contact_person_phone',
        'description',
        'status',
    ];

    /**
     * Get the stocks for the item supplier.
     *
     * @return HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(ItemStock::class, 'supplier_id');
    }

    /**
     * Scope to filter item suppliers by status.
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
     * Scope to search item suppliers by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('email', $search)
                ->orWhereLike('phone', $search);
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
            'status' => 'boolean',
        ];
    }
}
