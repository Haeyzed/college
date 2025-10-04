<?php

namespace App\Models\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Program Model - Version 1
 *
 * Represents an academic program in the College Management System.
 * This model handles program information, relationships with faculties,
 * batches, semesters, sessions, and students.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $faculty_id
 * @property string $title
 * @property string $slug
 * @property string $shortcode
 * @property string $registration
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Collection|Batch[] $batches
 * @property-read Collection|Semester[] $semesters
 * @property-read Collection|Session[] $sessions
 * @property-read Collection|ProgramSemesterSection[] $semesterSections
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read Collection|Subject[] $subjects
 * @property-read Collection|ClassRoom[] $rooms
 * @property-read Collection|Student[] $students
 * @property-read Collection|ClassRoutine[] $classes
 * @property-read Collection|User[] $users
 * @property-read Collection|Content[] $contents
 */
class Program extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'title',
        'slug',
        'shortcode',
        'registration',
        'status',
    ];

    /**
     * Get the faculty that owns the program.
     *
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the batches for the program.
     *
     * @return BelongsToMany
     */
    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_program', 'program_id', 'batch_id');
    }

    /**
     * Get the semesters for the program.
     *
     * @return BelongsToMany
     */
    public function semesters(): BelongsToMany
    {
        return $this->belongsToMany(Semester::class, 'program_semester', 'program_id', 'semester_id');
    }

    /**
     * Get the sessions for the program.
     *
     * @return BelongsToMany
     */
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'program_session', 'program_id', 'session_id');
    }

    /**
     * Get the semester sections for the program.
     *
     * @return HasMany
     */
    public function semesterSections(): HasMany
    {
        return $this->hasMany(ProgramSemesterSection::class);
    }

    /**
     * Get the student enrollments for the program.
     *
     * @return HasMany
     */
    public function studentEnrolls(): HasMany
    {
        return $this->hasMany(StudentEnroll::class);
    }

    /**
     * Get the subjects for the program.
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'program_subject', 'program_id', 'subject_id');
    }

    /**
     * Get the rooms for the program.
     *
     * @return BelongsToMany
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(ClassRoom::class, 'program_class_room', 'program_id', 'class_room_id');
    }

    /**
     * Get the students for the program.
     *
     * @return HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the classes for the program.
     *
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(ClassRoutine::class);
    }

    /**
     * Get the users for the program.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_program', 'program_id', 'user_id');
    }

    /**
     * Get the contents for the program.
     *
     * @return HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Scope to filter programs by status.
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
     * Scope to filter programs by faculty.
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
     * Scope to search programs by title or shortcode.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('title', $search)
                ->orWhereLike('shortcode', $search)
                ->orWhereLike('slug', $search);
        });
    }
}
