<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\v1\Status;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Batch Model - Version 1
 *
 * Represents an academic batch in the College Management System.
 * This model handles batch information and relationships with programs,
 * students, and academic records.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $program_id
 * @property string $name
 * @property string $code
 * @property int $academic_year
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int|null $max_students
 * @property string|null $description
 * @property string $status
 * @property int $sort_order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Program $program
 * @property-read Collection|Program[] $programs
 * @property-read Collection|Student[] $students
 * @property-read Collection|Application[] $applications
 * @property-read Collection|Section[] $sections
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Batch extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'name',
        'code',
        'academic_year',
        'start_date',
        'end_date',
        'max_students',
        'description',
        'status',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => Status::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the program that owns the batch.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the programs for the batch.
     *
     * @return BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'batch_program', 'batch_id', 'program_id');
    }

    /**
     * Get the students for the batch.
     *
     * @return HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the applications for the batch.
     *
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get the sections for the batch.
     *
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Scope to filter batches by status.
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
     * Scope to filter batches by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram(Builder $query, int $programId): Builder
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter batches by academic year.
     *
     * @param Builder $query
     * @param int $academicYear
     * @return Builder
     */
    public function scopeFilterByAcademicYear(Builder $query, int $academicYear): Builder
    {
        return $query->where('academic_year', $academicYear);
    }

    /**
     * Scope to search batches by name, code, or description.
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
     * Scope to order batches by sort order.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('academic_year', 'desc')->orderBy('name');
    }
}
