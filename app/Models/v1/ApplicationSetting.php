<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * ApplicationSetting Model - Version 1
 *
 * This model represents application settings and configurations
 * for the College Management System.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
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
        'fee_amount',
        'pay_online',
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
            'fee_amount' => 'decimal:2',
            'pay_online' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /**
     * Scope to filter application settings by status.
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
     * Scope to search application settings by title or slug.
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
     * Get the application status setting.
     *
     * @return ApplicationSetting|null
     */
    public static function status(): ?ApplicationSetting
    {
        return static::query()->where('status', true)->first();
    }
}
