<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ScheduleSettingResource - Version 1
 *
 * Resource for transforming ScheduleSetting model data into API responses.
 * This resource handles schedule setting data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ScheduleSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * The unique identifier of the schedule setting.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The unique slug identifier for the schedule setting.
             * @var string $slug
             * @example "daily_reminder"
             */
            'slug' => $this->slug,

            /**
             * The day of the week for the schedule.
             * @var string $day
             * @example "Monday"
             */
            'day' => $this->day,

            /**
             * The time for the schedule.
             * @var string $time
             * @example "09:00"
             */
            'time' => $this->time,

            /**
             * Whether email notifications are enabled.
             * @var bool $email
             * @example true
             */
            'email' => $this->email,

            /**
             * Whether SMS notifications are enabled.
             * @var bool $sms
             * @example true
             */
            'sms' => $this->sms,

            /**
             * The status of the schedule setting.
             * @var bool $status
             * @example true
             */
            'status' => $this->status,

            /**
             * The creation timestamp.
             * @var string|null $created_at
             * @example "2023-12-01 10:30:00"
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            /**
             * The last update timestamp.
             * @var string|null $updated_at
             * @example "2023-12-01 15:45:00"
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Computed fields
            /**
             * Whether the schedule setting is active.
             * @var bool $is_active
             * @example true
             */
            'is_active' => $this->status,

            /**
             * The formatted time for display.
             * @var string $formatted_time
             * @example "09:00 AM"
             */
            'formatted_time' => $this->formatTime($this->time),

            /**
             * The number of notification methods enabled.
             * @var int $notification_methods_count
             * @example 2
             */
            'notification_methods_count' => collect([
                $this->email,
                $this->sms
            ])->filter()->count(),

            /**
             * List of enabled notification methods.
             * @var array $enabled_notification_methods
             * @example ["email", "sms"]
             */
            'enabled_notification_methods' => collect([
                'email' => $this->email,
                'sms' => $this->sms
            ])->filter()->keys()->toArray(),

            /**
             * Whether email notifications are enabled.
             * @var bool $has_email_notifications
             * @example true
             */
            'has_email_notifications' => $this->email,

            /**
             * Whether SMS notifications are enabled.
             * @var bool $has_sms_notifications
             * @example true
             */
            'has_sms_notifications' => $this->sms,

            /**
             * The schedule description.
             * @var string $schedule_description
             * @example "Monday at 09:00 AM"
             */
            'schedule_description' => $this->day . ' at ' . $this->formatTime($this->time),

            /**
             * The notification summary.
             * @var string $notification_summary
             * @example "Email & SMS"
             */
            'notification_summary' => $this->getNotificationSummary(),

            /**
             * The day index for sorting (0=Sunday, 1=Monday, etc.).
             * @var int $day_index
             * @example 1
             */
            'day_index' => $this->getDayIndex($this->day),
        ];
    }

    /**
     * Format time for display.
     *
     * @param string $time
     * @return string
     */
    private function formatTime(string $time): string
    {
        try {
            $timeObj = Carbon::createFromFormat('H:i', $time);
            return $timeObj->format('g:i A');
        } catch (Exception $e) {
            return $time;
        }
    }

    /**
     * Get notification summary.
     *
     * @return string
     */
    private function getNotificationSummary(): string
    {
        $methods = [];

        if ($this->email) {
            $methods[] = 'Email';
        }

        if ($this->sms) {
            $methods[] = 'SMS';
        }

        return empty($methods) ? 'None' : implode(' & ', $methods);
    }

    /**
     * Get day index for sorting.
     *
     * @param string $day
     * @return int
     */
    private function getDayIndex(string $day): int
    {
        $days = [
            'Sunday' => 0,
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
        ];

        return $days[$day] ?? 0;
    }
}
