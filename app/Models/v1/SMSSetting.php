<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * SMSSetting Model - Version 1
 *
 * Represents an SMS setting in the College Management System.
 * This model handles SMS setting information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property string $nexmo_key
 * @property string $nexmo_secret
 * @property string $nexmo_sender_name
 * @property string $twilio_sid
 * @property string $twilio_auth_token
 * @property string $twilio_number
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SMSSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nexmo_key',
        'nexmo_secret',
        'nexmo_sender_name',
        'twilio_sid',
        'twilio_auth_token',
        'twilio_number',
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
            'status' => 'boolean',
        ];
    }

    /**
     * Scope to filter SMS settings by status.
     *
     * @param Builder $query
     * @param string $status
     * @return Builder
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
