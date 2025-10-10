<?php

namespace App\Models\v1\Web;

use App\Models\v1\Language;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Testimonial Model - Version 1
 *
 * Represents a testimonial in the College Management System.
 * This model handles testimonial information and relationships.
 *
 * @package App\Models\v1\Web
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $language_id
 * @property string $name
 * @property string $designation
 * @property string $description
 * @property int $rating
 * @property string $attach
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Language $language
 */
class Testimonial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'language_id',
        'name',
        'designation',
        'description',
        'rating',
        'attach',
        'status',
    ];

    /**
     * Get the language for the testimonial.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Scope to filter testimonials by status.
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
     * Scope to search testimonials by name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->whereLike('name', $search);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'language_id' => 'integer',
            'rating' => 'integer',
            'status' => 'boolean',
        ];
    }
}
