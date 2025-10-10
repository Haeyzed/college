<?php

namespace App\Models\v1;

use App\Enums\v1\BloodGroup;
use App\Enums\v1\MaritalStatus;
use App\Enums\v1\Religion;
use App\Enums\v1\Status;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Student Model - Version 1
 *
 * Represents a student in the College Management System.
 * This model handles student information, enrollment tracking,
 * and relationships with programs, batches, and academic records.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $student_id
 * @property string $registration_no
 * @property int $batch_id
 * @property int $program_id
 * @property Carbon $admission_date
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $father_occupation
 * @property string $mother_occupation
 * @property string|null $father_photo
 * @property string|null $mother_photo
 * @property string $email
 * @property string $password
 * @property string|null $password_text
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
 * @property string $login
 * @property string $status
 * @property bool $is_transfer
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Batch $batch
 * @property-read Program $program
 * @property-read Collection|StudentEnroll[] $studentEnrolls
 * @property-read StudentEnroll|null $currentEnroll
 * @property-read StudentEnroll|null $firstEnroll
 * @property-read StudentEnroll|null $lastEnroll
 * @property-read Collection|StudentRelative[] $relatives
 * @property-read Collection|Exam[] $exams
 * @property-read Collection|StudentLeave[] $leaves
 * @property-read Collection|Certificate[] $certificates
 * @property-read Province $presentProvince
 * @property-read District $presentDistrict
 * @property-read Province $permanentProvince
 * @property-read District $permanentDistrict
 * @property-read Collection|StatusType[] $statuses
 * @property-read StudentTransfer|null $studentTransfer
 * @property-read Collection|TransferCredit[] $transferCredits
 */
class Student extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'registration_no',
        'batch_id',
        'program_id',
        'admission_date',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'father_occupation',
        'mother_occupation',
        'father_photo',
        'mother_photo',
        'email',
        'password',
        'password_text',
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
        'login',
        'status',
        'is_transfer',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get current enrollment for a student.
     *
     * @param int $id
     * @return StudentEnroll|null
     */
    public static function enroll(int $id): ?StudentEnroll
    {
        return StudentEnroll::query()->where('student_id', $id)
            ->where('status', Status::ACTIVE->value)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get the batch that owns the student.
     *
     * @return BelongsTo
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get the program that owns the student.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the student enrollments.
     *
     * @return HasMany
     */
    public function studentEnrolls(): HasMany
    {
        return $this->hasMany(StudentEnroll::class);
    }

    /**
     * Get the current enrollment.
     *
     * @return HasOne
     */
    public function currentEnroll(): HasOne
    {
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('status', Status::ACTIVE->value);
        });
    }

    /**
     * Get the first enrollment.
     *
     * @return HasOne
     */
    public function firstEnroll(): HasOne
    {
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'min',
        ]);
    }

    /**
     * Get the last enrollment.
     *
     * @return HasOne
     */
    public function lastEnroll(): HasOne
    {
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'max',
        ]);
    }

    /**
     * Get the student relatives.
     *
     * @return HasMany
     */
    public function relatives(): HasMany
    {
        return $this->hasMany(StudentRelative::class, 'student_id', 'id');
    }

    /**
     * Get the student exams.
     *
     * @return HasMany
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, 'student_id', 'id');
    }

    /**
     * Get the student leaves.
     *
     * @return HasMany
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(StudentLeave::class, 'student_id', 'id');
    }

    /**
     * Get the student certificates.
     *
     * @return HasMany
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'student_id', 'id');
    }

    /**
     * Get the present province that owns the student.
     *
     * @return BelongsTo
     */
    public function presentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    /**
     * Get the present district that owns the student.
     *
     * @return BelongsTo
     */
    public function presentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    /**
     * Get the permanent province that owns the student.
     *
     * @return BelongsTo
     */
    public function permanentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    /**
     * Get the permanent district that owns the student.
     *
     * @return BelongsTo
     */
    public function permanentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    /**
     * Get the status types for the student.
     *
     * @return BelongsToMany
     */
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(StatusType::class, 'status_type_student', 'student_id', 'status_type_id');
    }

    /**
     * Get the student transfer.
     *
     * @return HasOne
     */
    public function studentTransfer(): HasOne
    {
        return $this->hasOne(StudentTransfer::class, 'student_id');
    }

    /**
     * Get the transfer credits.
     *
     * @return HasMany
     */
    public function transferCredits(): HasMany
    {
        return $this->hasMany(TransferCredit::class, 'student_id');
    }

    /**
     * Get the documents for the student.
     *
     * @return MorphToMany
     */
    public function documents(): MorphToMany
    {
        return $this->morphToMany(Document::class, 'docable');
    }

    /**
     * Get the contents for the student.
     *
     * @return MorphToMany
     */
    public function contents(): MorphToMany
    {
        return $this->morphToMany(Content::class, 'contentable');
    }

    /**
     * Get the notices for the student.
     *
     * @return MorphToMany
     */
    public function notices(): MorphToMany
    {
        return $this->morphToMany(Notice::class, 'noticeable');
    }

    /**
     * Get the library member for the student.
     *
     * @return MorphOne
     */
    public function member(): MorphOne
    {
        return $this->morphOne(LibraryMember::class, 'memberable');
    }

    /**
     * Get the hostel room for the student.
     *
     * @return MorphOne
     */
    public function hostelRoom(): MorphOne
    {
        return $this->morphOne(HostelMember::class, 'hostelable');
    }

    /**
     * Get the transport for the student.
     *
     * @return MorphOne
     */
    public function transport(): MorphOne
    {
        return $this->morphOne(TransportMember::class, 'transportable');
    }

    /**
     * Get the notes for the student.
     *
     * @return MorphMany
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    /**
     * Get the transactions for the student.
     *
     * @return MorphMany
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Scope to filter students by status.
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
     * Scope to filter students by program.
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
     * Scope to filter students by batch.
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
     * Scope to search students by name or email.
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
                ->orWhereLike('student_id', $search)
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
            'admission_date' => 'datetime',
            'dob' => 'datetime',
            'school_graduation_year' => 'integer',
            'school_graduation_point' => 'float',
            'college_graduation_year' => 'integer',
            'college_graduation_point' => 'float',
            'is_transfer' => 'boolean',
            'password' => 'hashed',
            'blood_group' => BloodGroup::class,
            'religion' => Religion::class,
            'marital_status' => MaritalStatus::class,
            'status' => Status::class,
        ];
    }
}
