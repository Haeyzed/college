<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Visitor Model - Version 1
 *
 * Represents a visitor in the College Management System.
 * This model handles visitor information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $purpose_id
 * @property int $department_id
 * @property string $name
 * @property string $father_name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $visit_from
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
 * @property-read VisitPurpose $purpose
 * @property-read Department $department
 * @property-read User $recordedBy
 */
class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purpose_id',
        'department_id',
        'name',
        'father_name',
        'phone',
        'email',
        'address',
        'visit_from',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purpose_id' => 'integer',
            'department_id' => 'integer',
            'persons' => 'integer',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'date' => 'date',
            'status' => 'boolean',
        ];
    }

    /**
     * Get the visit purpose for the visitor.
     *
     * @return BelongsTo
     */
    public function purpose(): BelongsTo
    {
        return $this->belongsTo(VisitPurpose::class, 'purpose_id');
    }

    /**
     * Get the department for the visitor.
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the user who recorded the visitor.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter visitors by status.
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
     * Scope to search visitors by name or phone.
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
}
