<?php

namespace App\Models\v1\Web;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * SocialSetting Model - Version 1
 *
 * Represents a social setting in the College Management System.
 * This model handles social setting information and relationships.
 *
 * @package App\Models\v1\Web
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $facebook
 * @property string $twitter
 * @property string $linkedin
 * @property string $instagram
 * @property string $pinterest
 * @property string $youtube
 * @property string $tiktok
 * @property string $skype
 * @property string $telegram
 * @property string $whatsapp
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SocialSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'pinterest',
        'youtube',
        'tiktok',
        'skype',
        'telegram',
        'whatsapp',
        'status',
    ];

    /**
     * Scope to filter social settings by status.
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
            'status' => 'boolean',
        ];
    }
}
