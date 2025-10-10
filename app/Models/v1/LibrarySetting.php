<?php

namespace App\Models\v1;

use App\Enums\v1\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * LibrarySetting Model - Version 1
 *
 * This model represents library settings and configurations
 * for the College Management System library module.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class LibrarySetting extends Model
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
        'library_name',
        'library_code',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'background',
        'fine_per_day',
        'max_books_per_student',
        'max_borrow_days',
        'auto_approve_requests',
        'require_approval',
        'send_notifications',
        'status',
    ];

    /**
     * Get the active library setting.
     *
     * @return LibrarySetting|null
     */
    public static function active(): ?LibrarySetting
    {
        return static::query()->where('status', Status::ACTIVE->value)->first();
    }

    /**
     * Scope to filter library settings by status.
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
     * Scope to search library settings by title, library name, or address.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('library_name', $search)
                ->orWhereLike('library_code', $search)
                ->orWhereLike('address', $search)
                ->orWhereLike('phone', $search)
                ->orWhereLike('email', $search);
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
            'fine_per_day' => 'decimal:2',
            'max_books_per_student' => 'integer',
            'max_borrow_days' => 'integer',
            'auto_approve_requests' => 'boolean',
            'require_approval' => 'boolean',
            'send_notifications' => 'boolean',
            'status' => Status::class,
        ];
    }
}
