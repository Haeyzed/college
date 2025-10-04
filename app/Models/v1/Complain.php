<?php

namespace App\Models\v1;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Complain Model - Version 1
 *
 * Represents a complaint in the College Management System.
 * This model handles complaint information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $type_id
 * @property int $source_id
 * @property string $name
 * @property string $father_name
 * @property string $phone
 * @property string $email
 * @property Carbon $date
 * @property string $action_taken
 * @property int $assigned
 * @property string $issue
 * @property string $note
 * @property string|null $attach
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read ComplainType $type
 * @property-read ComplainSource $source
 * @property-read User $assign
 * @property-read User $recordedBy
 */
class Complain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'source_id',
        'name',
        'father_name',
        'phone',
        'email',
        'date',
        'action_taken',
        'assigned',
        'issue',
        'note',
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
     * Get the type that owns the complaint.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ComplainType::class);
    }

    /**
     * Get the source that owns the complaint.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(ComplainSource::class);
    }

    /**
     * Get the assigned user for the complaint.
     *
     * @return BelongsTo
     */
    public function assign(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned');
    }

    /**
     * Get the user who recorded the complaint.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter complaints by status.
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
     * Scope to filter complaints by type.
     *
     * @param Builder $query
     * @param int $typeId
     * @return Builder
     */
    public function scopeFilterByType(Builder $query, int $typeId): Builder
    {
        return $query->where('type_id', $typeId);
    }

    /**
     * Scope to filter complaints by assigned user.
     *
     * @param Builder $query
     * @param int $assignedId
     * @return Builder
     */
    public function scopeFilterByAssigned(Builder $query, int $assignedId): Builder
    {
        return $query->where('assigned', $assignedId);
    }

    /**
     * Scope to search complaints by name, phone, or issue.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('phone', $search)
                ->orWhereLike('issue', $search);
        });
    }
}
