<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * StudentRelative Model - Version 1
 *
 * Represents a student relative in the College Management System.
 * This model handles relative information and relationships with students.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $student_id
 * @property string $name
 * @property string $relationship
 * @property string $phone
 * @property string $address
 * @property string $occupation
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Student $student
 */
class StudentRelative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'relationship',
        'phone',
        'address',
        'occupation',
    ];

    /**
     * Get the student that owns the relative.
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
