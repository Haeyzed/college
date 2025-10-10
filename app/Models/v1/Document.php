<?php

namespace App\Models\v1;

use App\Models\v1\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * Document Model - Version 1
 *
 * Represents a document in the College Management System.
 * This model handles document information and polymorphic relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $title
 * @property string $file_path
 * @property string $file_type
 * @property int $file_size
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection<int, Student> $students
 * @property-read Collection<int, User> $users
 */
class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'file_path',
        'status',
    ];

    /**
     * Get the students that own this document.
     *
     * @return MorphToMany
     */
    public function students(): MorphToMany
    {
        return $this->morphedByMany(Student::class, 'docable');
    }

    /**
     * Get the users that own this document.
     *
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'docable');
    }

    /**
     * Scope to filter documents by status.
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
     * Scope to search documents by title.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->whereLike('title', $search);
    }
}
