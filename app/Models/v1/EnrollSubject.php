<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\v1\Status;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * EnrollSubject Model - Version 1
 *
 * Represents subject enrollment for specific program, semester, and section combinations.
 * This model handles the enrollment of subjects for academic sections.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $program_id
 * @property int $semester_id
 * @property int $section_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read Program $program
 * @property-read Semester $semester
 * @property-read Section $section
 * @property-read \Illuminate\Database\Eloquent\Collection|Subject[] $subjects
 */
class EnrollSubject extends Model implements Auditable
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
        'semester_id',
        'section_id',
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
     * Get the program for the enroll subject.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the semester for the enroll subject.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the section for the enroll subject.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the subjects enrolled for this combination.
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'enroll_subject_subjects', 'enroll_subject_id', 'subject_id');
    }

    /**
     * Scope to filter enroll subjects by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter enroll subjects by program.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $programId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByProgram($query, int $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter enroll subjects by semester.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $semesterId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterBySemester($query, int $semesterId)
    {
        return $query->where('semester_id', $semesterId);
    }

    /**
     * Scope to filter enroll subjects by section.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $sectionId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterBySection($query, int $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
}