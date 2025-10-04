<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Language Model - Version 1
 *
 * Represents a language in the College Management System.
 * This model handles language information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $direction
 * @property bool $default
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'direction',
        'default',
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
            'default' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the language version based on session or default.
     *
     * @return Language|null
     */
    public static function version(): ?Language
    {
        if (session()->has('locale')) {
            return static::where('code', session()->get('locale'))->first();
        } else {
            return static::where('default', true)->first();
        }
    }

    /**
     * Scope to filter languages by status.
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
     * Scope to search languages by name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('code', $search);
        });
    }
}
