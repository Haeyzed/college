<?php

namespace App\Models\v1;

use App\Enums\v1\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MailSetting Model - Version 1
 *
 * Represents a mail setting in the College Management System.
 * This model handles mail setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $driver
 * @property string $host
 * @property int $port
 * @property string $username
 * @property string $password
 * @property string $encryption
 * @property string $sender_email
 * @property string $sender_name
 * @property string $reply_email
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MailSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'sender_email',
        'sender_name',
        'reply_email',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'port' => 'integer',
            'status' => Status::class,
        ];
    }

    /**
     * Scope to filter mail settings by status.
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
     * Scope to search mail settings by driver, host, or sender email.
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->whereLike('driver', $search)
                ->orWhereLike('host', $search)
                ->orWhereLike('sender_email', $search)
                ->orWhereLike('sender_name', $search)
                ->orWhereLike('username', $search);
        });
    }
}
