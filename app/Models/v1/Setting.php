<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Setting Model - Version 1
 *
 * Represents a setting in the College Management System.
 * This model handles setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $academy_code
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $logo_path
 * @property string $favicon_path
 * @property string $phone
 * @property string $email
 * @property string $fax
 * @property string $address
 * @property string $language
 * @property string $date_format
 * @property string $time_format
 * @property string $week_start
 * @property string $time_zone
 * @property string $currency
 * @property string $currency_symbol
 * @property int $decimal_place
 * @property string $copyright_text
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'academy_code',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'logo_path',
        'favicon_path',
        'phone',
        'email',
        'fax',
        'address',
        'language',
        'date_format',
        'time_format',
        'week_start',
        'time_zone',
        'currency',
        'currency_symbol',
        'decimal_place',
        'copyright_text',
        'status',
    ];

    /**
     * Scope to filter settings by status.
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
            'decimal_place' => 'integer',
            'status' => 'boolean',
        ];
    }
}
