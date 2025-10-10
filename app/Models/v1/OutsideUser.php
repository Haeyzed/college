<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * OutsideUser Model - Version 1
 *
 * Represents an outside user in the College Management System.
 * This model handles outside user information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $father_occupation
 * @property string $mother_occupation
 * @property string $father_photo
 * @property string $mother_photo
 * @property string $email
 * @property string $phone
 * @property string $country
 * @property int $present_province
 * @property int $present_district
 * @property string $present_village
 * @property string $present_address
 * @property int $permanent_province
 * @property int $permanent_district
 * @property string $permanent_village
 * @property string $permanent_address
 * @property string $education_level
 * @property string $occupation
 * @property string $gender
 * @property string $dob
 * @property string $religion
 * @property string $caste
 * @property string $mother_tongue
 * @property string $marital_status
 * @property string $blood_group
 * @property string $nationality
 * @property string $national_id
 * @property string $passport_no
 * @property string $photo
 * @property string $signature
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read LibraryMember $member
 * @property-read Province $presentProvince
 * @property-read District $presentDistrict
 * @property-read Province $permanentProvince
 * @property-read District $permanentDistrict
 */
class OutsideUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'father_occupation',
        'mother_occupation',
        'father_photo',
        'mother_photo',
        'email',
        'phone',
        'country',
        'present_province',
        'present_district',
        'present_village',
        'present_address',
        'permanent_province',
        'permanent_district',
        'permanent_village',
        'permanent_address',
        'education_level',
        'occupation',
        'gender',
        'dob',
        'religion',
        'caste',
        'mother_tongue',
        'marital_status',
        'blood_group',
        'nationality',
        'national_id',
        'passport_no',
        'photo',
        'signature',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the library member for the outside user.
     *
     * @return MorphOne
     */
    public function member(): MorphOne
    {
        return $this->morphOne(LibraryMember::class, 'memberable');
    }

    /**
     * Get the present province for the outside user.
     *
     * @return BelongsTo
     */
    public function presentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    /**
     * Get the present district for the outside user.
     *
     * @return BelongsTo
     */
    public function presentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    /**
     * Get the permanent province for the outside user.
     *
     * @return BelongsTo
     */
    public function permanentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    /**
     * Get the permanent district for the outside user.
     *
     * @return BelongsTo
     */
    public function permanentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    /**
     * Scope to filter outside users by status.
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
     * Scope to search outside users by name or email.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('first_name', $search)
                ->orWhereLike('last_name', $search)
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
            'present_province' => 'integer',
            'present_district' => 'integer',
            'permanent_province' => 'integer',
            'permanent_district' => 'integer',
            'dob' => 'date',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'status' => 'boolean',
        ];
    }
}
