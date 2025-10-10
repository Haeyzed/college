<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * EmailNotify Model - Version 1
 *
 * Represents an email notification in the College Management System.
 * This model handles email notification information and relationships.
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
 * @property string $subject
 * @property string $message
 * @property int $receive_count
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Program $program
 * @property-read Session $session
 * @property-read Semester $semester
 * @property-read Section $section
 * @property-read User $recordedBy
 */
class EmailNotify extends Model
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
        'subject',
        'message',
        'receive_count',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the faculty for the email notification.
     *
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    /**
     * Get the program for the email notification.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the session for the email notification.
     *
     * @return BelongsTo
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * Get the semester for the email notification.
     *
     * @return BelongsTo
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the section for the email notification.
     *
     * @return BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get the user who recorded the email notification.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter email notifications by status.
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
     * Scope to search email notifications by subject.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('subject', $search)
                ->orWhereLike('message', $search);
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
            'faculty_id' => 'integer',
            'program_id' => 'integer',
            'session_id' => 'integer',
            'semester_id' => 'integer',
            'section_id' => 'integer',
            'receive_count' => 'integer',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
