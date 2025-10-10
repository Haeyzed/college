<?php

namespace App\Models\v1;

use App\Enums\v1\ApplicationStatus;
use App\Enums\v1\BloodGroup;
use App\Enums\v1\MaritalStatus;
use App\Enums\v1\Religion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Application Model - Version 1
 *
 * Represents a student application in the College Management System.
 * This model handles application lifecycle, status tracking,
 * and relationships with batches, programs, and provinces.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $registration_no
 * @property int $batch_id
 * @property int $program_id
 * @property Carbon $apply_date
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $father_occupation
 * @property string $mother_occupation
 * @property string|null $father_photo
 * @property string|null $mother_photo
 * @property string $country
 * @property int $present_province
 * @property int $present_district
 * @property string $present_village
 * @property string $present_address
 * @property int $permanent_province
 * @property int $permanent_district
 * @property string $permanent_village
 * @property string $permanent_address
 * @property string $gender
 * @property Carbon $dob
 * @property string $email
 * @property string $phone
 * @property string $emergency_phone
 * @property string $religion
 * @property string $caste
 * @property string $mother_tongue
 * @property string $marital_status
 * @property string $blood_group
 * @property string $nationality
 * @property string|null $national_id
 * @property string|null $passport_no
 * @property string $school_name
 * @property string $school_exam_id
 * @property string $school_graduation_field
 * @property int $school_graduation_year
 * @property float $school_graduation_point
 * @property string|null $school_transcript
 * @property string|null $school_certificate
 * @property string $college_name
 * @property string $college_exam_id
 * @property string $college_graduation_field
 * @property int $college_graduation_year
 * @property float $college_graduation_point
 * @property string|null $college_transcript
 * @property string|null $college_certificate
 * @property string|null $photo
 * @property string|null $signature
 * @property float $fee_amount
 * @property string $pay_status
 * @property string $payment_method
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Batch $batch
 * @property-read Program $program
 * @property-read Province $presentProvince
 * @property-read District $presentDistrict
 * @property-read Province $permanentProvince
 * @property-read District $permanentDistrict
 */
class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_no',
        'batch_id',
        'program_id',
        'apply_date',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'father_occupation',
        'mother_occupation',
        'father_photo',
        'mother_photo',
        'country',
        'present_province',
        'present_district',
        'present_village',
        'present_address',
        'permanent_province',
        'permanent_district',
        'permanent_village',
        'permanent_address',
        'gender',
        'dob',
        'email',
        'phone',
        'emergency_phone',
        'religion',
        'caste',
        'mother_tongue',
        'marital_status',
        'blood_group',
        'nationality',
        'national_id',
        'passport_no',
        'school_name',
        'school_exam_id',
        'school_graduation_field',
        'school_graduation_year',
        'school_graduation_point',
        'school_transcript',
        'school_certificate',
        'college_name',
        'college_exam_id',
        'college_graduation_field',
        'college_graduation_year',
        'college_graduation_point',
        'college_transcript',
        'college_certificate',
        'photo',
        'signature',
        'fee_amount',
        'pay_status',
        'payment_method',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the batch that owns the application.
     *
     * @return BelongsTo
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the program that owns the application.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the present province that owns the application.
     *
     * @return BelongsTo
     */
    public function presentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    /**
     * Get the present district that owns the application.
     *
     * @return BelongsTo
     */
    public function presentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    /**
     * Get the permanent province that owns the application.
     *
     * @return BelongsTo
     */
    public function permanentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    /**
     * Get the permanent district that owns the application.
     *
     * @return BelongsTo
     */
    public function permanentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    /**
     * Scope to filter applications by status.
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
     * Scope to filter applications by program.
     *
     * @param Builder $query
     * @param int $programId
     * @return Builder
     */
    public function scopeFilterByProgram(Builder $query, int $programId): Builder
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope to filter applications by batch.
     *
     * @param Builder $query
     * @param int $batchId
     * @return Builder
     */
    public function scopeFilterByBatch(Builder $query, int $batchId): Builder
    {
        return $query->where('batch_id', $batchId);
    }

    /**
     * Scope to filter applications by payment status.
     *
     * @param Builder $query
     * @param string $payStatus
     * @return Builder
     */
    public function scopeFilterByPaymentStatus(Builder $query, string $payStatus): Builder
    {
        return $query->where('pay_status', $payStatus);
    }

    /**
     * Scope to search applications by name or email.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('first_name', $search)
                ->orWhereLike('last_name', $search)
                ->orWhereLike('email', $search)
                ->orWhereLike('registration_no', $search);
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
            'apply_date' => 'datetime',
            'dob' => 'datetime',
            'school_graduation_year' => 'integer',
            'school_graduation_point' => 'float',
            'college_graduation_year' => 'integer',
            'college_graduation_point' => 'float',
            'fee_amount' => 'float',
            'blood_group' => BloodGroup::class,
            'religion' => Religion::class,
            'marital_status' => MaritalStatus::class,
        ];
    }
}
