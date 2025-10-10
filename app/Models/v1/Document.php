<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'file_type',
        'file_size',
        'status',
    ];

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
     * Scope to filter documents by file type.
     *
     * @param Builder $query
     * @param string $fileType
     * @return Builder
     */
    public function scopeFilterByFileType(Builder $query, string $fileType): Builder
    {
        return $query->where('file_type', $fileType);
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }
}
