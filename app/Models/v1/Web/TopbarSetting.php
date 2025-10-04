<?php

namespace App\Models\v1\Web;

use App\Enums\v1\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * TopbarSetting Model - Version 1
 *
 * Represents a topbar setting in the College Management System.
 * This model handles topbar setting information and relationships.
 *
 * @package App\Models\v1\Web
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $address_title
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $working_hour
 * @property string $about_title
 * @property string $about_summery
 * @property string $social_title
 * @property string $social_status
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TopbarSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address_title',
        'address',
        'email',
        'phone',
        'working_hour',
        'about_title',
        'about_summery',
        'social_title',
        'social_status',
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
            'social_status' => 'boolean',
            'status' => Status::class,
        ];
    }

    /**
     * Scope to filter topbar settings by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
