<?php

namespace App\Models\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Notice Model - Version 1
 *
 * Represents a notice in the College Management System.
 * This model handles notice information and relationships with academic entities.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $program_id
 * @property int $session_id
 * @property int $semester_id
 * @property int $section_id
 * @property int $category_id
 * @property string $notice_no
 * @property string $title
 * @property string $description
 * @property Carbon $date
 * @property string|null $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read NoticeCategory $category
 * @property-read Faculty $faculty
 * @property-read Program $program
 * @property-read Session $session
 * @property-read Semester $semester
 * @property-read Section $section
 * @property-read Collection|User[] $users
 * @property-read Collection|Student[] $students
 */
class Notice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'program_id',
        'session_id',
        'semester_id',
        'section_id',
        'category_id',
        'notice_no',
        'title',
        'description',
        'date',
        'attach',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    /**
     * Get the category that owns the notice.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NoticeCategory::class);
    }

    /**
     * Get the faculty that owns the notice.
     *
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the program that owns the notice.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the session that owns the notice.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the semester that owns the notice.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the section that owns the notice.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the users that are associated with the notice.
     *
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'noticeable');
    }

    /**
     * Get the students that are associated with the notice.
     *
     * @return MorphToMany
     */
    public function students(): MorphToMany
    {
        return $this->morphedByMany(Student::class, 'noticeable');
    }

    /**
     * Scope to filter notices by status.
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
     * Scope to filter notices by faculty.
     *
     * @param Builder $query
     * @param int $facultyId
     * @return Builder
     */
    public function scopeFilterByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    /**
     * Scope to filter notices by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to search notices by title or description.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('description', $search)
                ->orWhereLike('notice_no', $search);
        });
    }
}
