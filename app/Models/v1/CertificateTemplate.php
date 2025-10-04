<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * CertificateTemplate Model - Version 1
 *
 * Represents a certificate template in the College Management System.
 * This model handles certificate template information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $header_left
 * @property string $header_center
 * @property string $header_right
 * @property string $body
 * @property string $footer_left
 * @property string $footer_center
 * @property string $footer_right
 * @property string $logo_left
 * @property string $logo_right
 * @property string $background
 * @property int $width
 * @property int $height
 * @property bool $student_photo
 * @property bool $barcode
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|Certificate[] $certificates
 */
class CertificateTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'header_left',
        'header_center',
        'header_right',
        'body',
        'footer_left',
        'footer_center',
        'footer_right',
        'logo_left',
        'logo_right',
        'background',
        'width',
        'height',
        'student_photo',
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
            'width' => 'integer',
            'height' => 'integer',
            'student_photo' => 'boolean',
            'barcode' => 'boolean',
        ];
    }

    /**
     * Get the certificates for the template.
     *
     * @return HasMany
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'template_id');
    }

    /**
     * Scope to filter templates by status.
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
     * Scope to search templates by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->whereLike('title', $search);
    }
}
