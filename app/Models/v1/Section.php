<?php

namespace App\Models\v1;

use App\Enums\v1\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Section Model - Version 1
 *
 * Represents an academic section in the College Management System.
 * This model handles section information and relationships with students and assignments.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property int|null $seat
 * @property string|null $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|ProgramSemesterSection[] $semesterPrograms
 * @property-read Collection|ProgramSemesterSection[] $programSemesters
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|Content[] $contents
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Section extends Model implements Auditable
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
        'seat',
        'description',
        'status',
    ];

    /**
     * Get the program semester sections associated with the section.
     *
     * @return HasMany
     */
    public function semesterPrograms(): HasMany
    {
        return $this->hasMany(ProgramSemesterSection::class, 'section_id', 'id');
    }

    /**
     * Get the program semester sections associated with the section (alias).
     *
     * @return HasMany
     */
    public function programSemesters(): HasMany
    {
        return $this->hasMany(ProgramSemesterSection::class, 'section_id', 'id');
    }

    /**
     * Get the student enrollment records associated with the section.
     *
     * @return HasMany
     */
    public function studentEnrolls(): HasMany
    {
        return $this->hasMany(StudentEnroll::class, 'section_id');
    }

    /**
     * Get the class routines associated with the section.
     *
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoutine::class, 'section_id', 'id');
    }

    /**
     * Get the academic contents uploaded for this section.
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'section_id', 'id');
    }

    /**
     * Scope to filter sections by status.
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
     * Scope to filter sections by batch.
     *
     * @param Builder $query
     * @param int $batchId
     * @return Builder
     */
    public function scopeFilterByBatch(Builder $query, int $batchId): Builder
    {
        return $query->where('batch_id', $batchId);
    }

    /**
     * Scope to search sections by name, code, or description.
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
                ->orWhereLike('description', $search);
        });
    }

    /**
     * Scope to order sections by sort order.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

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
}
