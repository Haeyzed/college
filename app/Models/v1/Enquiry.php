<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Enquiry Model - Version 1
 *
 * Represents an enquiry in the College Management System.
 * This model handles enquiry information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $reference_id
 * @property int $source_id
 * @property int $program_id
 * @property string $name
 * @property string $father_name
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $purpose
 * @property string $note
 * @property string $date
 * @property string $follow_up_date
 * @property int $assigned
 * @property int $number_of_students
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read EnquiryReference $reference
 * @property-read EnquirySource $source
 * @property-read Program $program
 * @property-read User $assign
 * @property-read User $recordedBy
 */
class Enquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_id',
        'source_id',
        'program_id',
        'name',
        'father_name',
        'phone',
        'email',
        'address',
        'purpose',
        'note',
        'date',
        'follow_up_date',
        'assigned',
        'number_of_students',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the enquiry reference for the enquiry.
     *
     * @return BelongsTo
     */
    public function reference(): BelongsTo
    {
        return $this->belongsTo(EnquiryReference::class, 'reference_id');
    }

    /**
     * Get the enquiry source for the enquiry.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(EnquirySource::class, 'source_id');
    }

    /**
     * Get the program for the enquiry.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the assigned user for the enquiry.
     *
     * @return BelongsTo
     */
    public function assign(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned');
    }

    /**
     * Get the user who recorded the enquiry.
     *
     * @return BelongsTo
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter enquiries by status.
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
     * Scope to search enquiries by name or email.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('name', $search)
                ->orWhereLike('email', $search)
                ->orWhereLike('phone', $search);
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
            'reference_id' => 'integer',
            'source_id' => 'integer',
            'program_id' => 'integer',
            'assigned' => 'integer',
            'number_of_students' => 'integer',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'date' => 'date',
            'follow_up_date' => 'date',
            'status' => 'boolean',
        ];
    }
}
