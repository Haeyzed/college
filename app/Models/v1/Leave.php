<?php

namespace App\Models\v1;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Leave Model - Version 1
 *
 * Represents a leave in the College Management System.
 * This model handles leave information and relationships.
 *
 * @package App\Models\v1
 * @version 1.0.0
 * @author Softmax Technologies
 *
 * @property int $id
 * @property int $type_id
 * @property int $user_id
 * @property int $review_by
 * @property string $apply_date
 * @property string $from_date
 * @property string $to_date
 * @property string $reason
 * @property string $attach
 * @property string $note
 * @property int $pay_type
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 * @property-read User $reviewBy
 * @property-read LeaveType $leaveType
 */
class Leave extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'user_id',
        'review_by',
        'apply_date',
        'from_date',
        'to_date',
        'reason',
        'attach',
        'note',
        'pay_type',
        'status',
    ];

    /**
     * Get paid leave count in a month.
     *
     * @param int $id
     * @param int $month
     * @param int $year
     * @return int
     */
    public static function paid_leave($id, $month, $year): int
    {
        $paid_leave = 0;

        $lfroms = static::where('status', true)->whereMonth('from_date', $month)->whereYear('from_date', $year)->get();
        if (isset($lfroms)) {
            foreach ($lfroms as $lfrom) {
                if ($lfrom->to_date <= date("Y-m-t", strtotime($year . '-' . $month . '-01'))) {
                    if ($lfrom->pay_type == 1) {
                        $paid_leave = $paid_leave + (int)((strtotime($lfrom->to_date) - strtotime($lfrom->from_date)) / 86400) + 1;
                    }
                } else {
                    if ($lfrom->pay_type == 1) {
                        $paid_leave = $paid_leave + (int)((strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01'))) - strtotime($lfrom->from_date)) / 86400) + 1;
                    }
                }
            }
        }

        $ltos = static::where('status', true)->whereMonth('to_date', $month)->whereYear('to_date', $year)->get();
        if (isset($ltos)) {
            foreach ($ltos as $lto) {
                if ($lto->from_date >= date("Y-m-d", strtotime($year . '-' . $month . '-01'))) {
                    //
                } else {
                    if ($lto->pay_type == 1) {
                        $paid_leave = $paid_leave + (int)((strtotime($lto->to_date) - strtotime(date("Y-m-d", strtotime($year . '-' . $month . '-01')))) / 86400) + 1;
                    }
                }
            }
        }

        return $paid_leave;
    }

    /**
     * Get unpaid leave count in a month.
     *
     * @param int $id
     * @param int $month
     * @param int $year
     * @return int
     */
    public static function unpaid_leave($id, $month, $year): int
    {
        $unpaid_leave = 0;

        $lfroms = static::where('user_id', $id)->where('status', true)->whereMonth('from_date', $month)->whereYear('from_date', $year)->get();
        if (isset($lfroms)) {
            foreach ($lfroms as $lfrom) {
                if ($lfrom->to_date <= date("Y-m-t", strtotime($year . '-' . $month . '-01'))) {
                    if ($lfrom->pay_type == 2) {
                        $unpaid_leave = $unpaid_leave + (int)((strtotime($lfrom->to_date) - strtotime($lfrom->from_date)) / 86400) + 1;
                    }
                } else {
                    if ($lfrom->pay_type == 2) {
                        $unpaid_leave = $unpaid_leave + (int)((strtotime(date("Y-m-t", strtotime($year . '-' . $month . '-01'))) - strtotime($lfrom->from_date)) / 86400) + 1;
                    }
                }
            }
        }

        $ltos = static::where('user_id', $id)->where('status', true)->whereMonth('to_date', $month)->whereYear('to_date', $year)->get();
        if (isset($ltos)) {
            foreach ($ltos as $lto) {
                if ($lto->from_date >= date("Y-m-d", strtotime($year . '-' . $month . '-01'))) {
                    //
                } else {
                    if ($lto->pay_type == 2) {
                        $unpaid_leave = $unpaid_leave + (int)((strtotime($lto->to_date) - strtotime(date("Y-m-d", strtotime($year . '-' . $month . '-01')))) / 86400) + 1;
                    }
                }
            }
        }

        return $unpaid_leave;
    }

    /**
     * Get the user for the leave.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who reviewed the leave.
     *
     * @return BelongsTo
     */
    public function reviewBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'review_by');
    }

    /**
     * Get the leave type for the leave.
     *
     * @return BelongsTo
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }

    /**
     * Scope to filter leaves by status.
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type_id' => 'integer',
            'user_id' => 'integer',
            'review_by' => 'integer',
            'apply_date' => 'date',
            'from_date' => 'date',
            'to_date' => 'date',
            'pay_type' => 'integer',
            'status' => 'boolean',
        ];
    }
}
