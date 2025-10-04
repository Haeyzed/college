<?php

namespace App\Models\v1;

use Carbon\Carbon;
use App\Enums\v1\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * IdCardSetting Model - Version 1
 *
 * Represents an ID card setting in the College Management System.
 * This model handles ID card setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $logo
 * @property string $background
 * @property string $website_url
 * @property string $validity
 * @property string $address
 * @property string $prefix
 * @property bool $student_photo
 * @property bool $signature
 * @property bool $barcode
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class IdCardSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'logo',
        'background',
        'website_url',
        'validity',
        'address',
        'prefix',
        'student_photo',
        'signature',
        'barcode',
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
            'student_photo' => 'boolean',
            'signature' => 'boolean',
            'barcode' => 'boolean',
            'status' => Status::class,
        ];
    }

    /**
     * Scope to filter ID card settings by status.
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
     * Scope to search ID card settings by title, slug, or subtitle.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('subtitle', $search)
                ->orWhereLike('address', $search);
        });
    }
}
