<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * PrintSetting Model - Version 1
 *
 * Represents a print setting in the College Management System.
 * This model handles print setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $slug
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
 * @property string $prefix
 * @property bool $student_photo
 * @property bool $barcode
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PrintSetting extends Model
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
        'prefix',
        'student_photo',
        'barcode',
        'status',
    ];

    /**
     * Scope to filter print settings by status.
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
     * Scope to search print settings by title, slug, or body.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('slug', $search)
                ->orWhereLike('header_left', $search)
                ->orWhereLike('header_center', $search)
                ->orWhereLike('header_right', $search)
                ->orWhereLike('body', $search);
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
            'width' => 'integer',
            'height' => 'integer',
            'student_photo' => 'boolean',
            'barcode' => 'boolean',
            'status' => 'boolean',
        ];
    }
}
