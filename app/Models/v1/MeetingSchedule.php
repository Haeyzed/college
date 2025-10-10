<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MeetingSchedule Model - Version 1
 *
 * Represents a meeting schedule in the College Management System.
 * This model handles meeting schedule information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $type_id
 * @property int $user_id
 * @property string $name
 * @property string $father_name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $purpose
 * @property string $id_no
 * @property string $token
 * @property string $date
 * @property string $in_time
 * @property string $out_time
 * @property int $persons
 * @property string $note
 * @property string $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read MeetingType $type
 * @property-read User $user
 * @property-read User $recordedBy
 */
class MeetingSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'user_id',
        'name',
        'father_name',
        'phone',
        'email',
        'address',
        'purpose',
        'id_no',
        'token',
        'date',
        'in_time',
        'out_time',
        'persons',
        'note',
        'attach',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the meeting type for the meeting schedule.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(MeetingType::class, 'type_id');
    }

    /**
     * Get the user for the meeting schedule.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who recorded the meeting schedule.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter meeting schedules by status.
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
     * Scope to search meeting schedules by name or phone.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('phone', $search)
                ->orWhereLike('email', $search);
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
            'type_id' => 'integer',
            'user_id' => 'integer',
            'persons' => 'integer',
            'date' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
