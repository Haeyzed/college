<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StaffHourlyAttendance Model - Version 1
 *
 * Represents a staff hourly attendance in the College Management System.
 * This model handles staff hourly attendance information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $user_id
 * @property int $subject_id
 * @property int $session_id
 * @property int $program_id
 * @property int $semester_id
 * @property int $section_id
 * @property string $start_time
 * @property string $end_time
 * @property string $date
 * @property string $attendance
 * @property string $note
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 * @property-read Subject $subject
 * @property-read Session $session
 * @property-read Program $program
 * @property-read Semester $semester
 * @property-read Section $section
 */
class StaffHourlyAttendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'session_id',
        'program_id',
        'semester_id',
        'section_id',
        'start_time',
        'end_time',
        'date',
        'attendance',
        'note',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subject for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get the session for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * Get the program for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the semester for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the section for the staff hourly attendance.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Scope to filter staff hourly attendances by attendance status.
     *
     * @param Builder $query
     * @param string $attendance
     * @return Builder
     */
    public function scopeFilterByAttendance($query, $attendance)
    {
        return $query->where('attendance', $attendance);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'subject_id' => 'integer',
            'session_id' => 'integer',
            'program_id' => 'integer',
            'semester_id' => 'integer',
            'section_id' => 'integer',
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ];
    }
}
