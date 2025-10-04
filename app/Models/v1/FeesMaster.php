<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * FeesMaster Model - Version 1
 *
 * Represents a fees master in the College Management System.
 * This model handles fees master information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $category_id
 * @property int $faculty_id
 * @property int $program_id
 * @property int $session_id
 * @property int $semester_id
 * @property int $section_id
 * @property float $amount
 * @property string $type
 * @property string $assign_date
 * @property string $due_date
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read FeesCategory $category
 * @property-read Faculty $faculty
 * @property-read Program $program
 * @property-read Session $session
 * @property-read Semester $semester
 * @property-read Section $section
 */
class FeesMaster extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'faculty_id',
        'program_id',
        'session_id',
        'semester_id',
        'section_id',
        'amount',
        'type',
        'assign_date',
        'due_date',
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
            'category_id' => 'integer',
            'faculty_id' => 'integer',
            'program_id' => 'integer',
            'session_id' => 'integer',
            'semester_id' => 'integer',
            'section_id' => 'integer',
            'amount' => 'decimal:2',
            'assign_date' => 'date',
            'due_date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the student enrolls for the fees master.
     *
     * @return BelongsToMany
     */
    public function studentEnrolls(): BelongsToMany
    {
        return $this->belongsToMany(StudentEnroll::class, 'fees_master_student_enroll', 'fees_master_id', 'student_enroll_id');
    }

    /**
     * Get the fees category for the fees master.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }

    /**
     * Get the faculty for the fees master.
     *
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    /**
     * Get the program for the fees master.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the session for the fees master.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * Get the semester for the fees master.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the section for the fees master.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Scope to filter fees masters by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
