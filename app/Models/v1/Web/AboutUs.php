<?php

namespace App\Models\v1\Web;

use App\Models\v1\Language;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AboutUs Model - Version 1
 *
 * Represents an about us page in the College Management System.
 * This model handles about us information and relationships.
 *
 * @package App\Models\v1\Web
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $language_id
 * @property string $label
 * @property string $title
 * @property string $short_desc
 * @property string $description
 * @property string $features
 * @property string $attach
 * @property string $video_id
 * @property string $button_text
 * @property string $mission_title
 * @property string $mission_desc
 * @property string $mission_icon
 * @property string $mission_image
 * @property string $vision_title
 * @property string $vision_desc
 * @property string $vision_icon
 * @property string $vision_image
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Language $language
 */
class AboutUs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'language_id',
        'label',
        'title',
        'short_desc',
        'description',
        'features',
        'attach',
        'video_id',
        'button_text',
        'mission_title',
        'mission_desc',
        'mission_icon',
        'mission_image',
        'vision_title',
        'vision_desc',
        'vision_icon',
        'vision_image',
        'status',
    ];

    /**
     * Get the language for the about us.
     *
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Scope to filter about us by status.
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
     * Scope to search about us by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('label', $search);
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
            'language_id' => 'integer',
            'status' => 'boolean',
        ];
    }
}
