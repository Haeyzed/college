<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StaffAttendance Model - Version 1
 *
 * Represents a staff attendance in the College Management System.
 * This model handles staff attendance information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $user_id
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
 */
class StaffAttendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'date',
        'attendance',
        'note',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user for the staff attendance.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope to filter staff attendances by attendance status.
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
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ];
    }
}
