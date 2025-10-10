<?php

namespace App\Models\v1;

use App\Enums\v1\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

// Added missing use statement for Session

/**
 * Semester Model - Version 1
 *
 * Represents an academic semester in the College Management System.
 * This model handles semester information and relationships with programs,
 * sessions, and student enrollments.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $name
 * @property int $academic_year
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property bool $is_current
 * @property string|null $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Program[] $programs
 * @property-read Collection|Session[] $sessions
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read Collection|ProgramSemesterSection[] $programSections
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|Content[] $contents
 *
 * @method static Builder withTrashed(bool $withTrashed = true)
 * @method static Builder onlyTrashed()
 * @method static Builder withoutTrashed()
 */
class Semester extends Model implements Auditable
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
        'academic_year',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'status',
    ];

    /**
     * Get the program semester sections associated with the semester.
     *
     * @return HasMany
     */
    public function programSections(): HasMany
    {
        return $this->hasMany(ProgramSemesterSection::class, 'semester_id', 'id');
    }

    /**
     * Get the class routines associated with the semester.
     *
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoutine::class, 'semester_id', 'id');
    }

    /**
     * Get the academic contents uploaded for this semester.
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'semester_id', 'id');
    }

    /**
     * Get the programs for the semester.
     *
     * @return BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_semester', 'semester_id', 'program_id');
    }

    /**
     * Get the student enrollments for the semester.
     *
     * @return HasMany
     */
    public function studentEnrolls(): HasMany
    {
        return $this->hasMany(StudentEnroll::class);
    }

    /**
     * Scope to filter semesters by status.
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
     * Scope to filter semesters by academic year.
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
     * Scope to filter current semesters.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope to search semesters by name, code, or description.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'status' => Status::class,
            'deleted_at' => 'datetime',
        ];
    }
}
