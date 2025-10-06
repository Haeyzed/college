<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Enums\v1\Status;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Faculty Model - Version 1
 *
 * Represents a faculty in the College Management System.
 * This model handles faculty information and relationships with programs.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string|null $description
 * @property string|null $dean_name
 * @property string|null $dean_email
 * @property string|null $dean_phone
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Program[] $programs
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Faculty extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'dean_name',
        'dean_email',
        'dean_phone',
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
            'status' => Status::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     * Generates slug before creation/update.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($faculty) {
            $faculty->slug = Str::slug($faculty->name);
        });

        static::updating(function ($faculty) {
            // Only update slug if name has changed
            if ($faculty->isDirty('name')) {
                $faculty->slug = Str::slug($faculty->name);
            }
        });
    }

    /**
     * Get the programs for the faculty.
     *
     * @return HasMany
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Scope to filter faculties by status.
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
     * Scope to search faculties by name, code, or dean name.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('code', $search)
                ->orWhereLike('dean_name', $search);
        });
    }
}
