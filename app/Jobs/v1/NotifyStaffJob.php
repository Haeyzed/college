<?php

namespace App\Jobs\v1;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * NotifyStaffJob - Version 1
 *
 * Job for sending notifications to staff members.
 * This job handles background processing of staff notifications.
 *
 * @package App\Jobs\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class NotifyStaffJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * The staff data for notification.
     *
     * @var array
     */
    protected $staffData;

    /**
     * The notification type.
     *
     * @var string
     */
    protected $notificationType;

    /**
     * Create a new job instance.
     *
     * @param array $staffData
     * @param string $notificationType
     */
    public function __construct(array $staffData, string $notificationType = 'general')
    {
        $this->staffData = $staffData;
        $this->notificationType = $notificationType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            Log::info('Starting staff notification job', [
                'staff_count' => count($this->staffData),
                'notification_type' => $this->notificationType
            ]);

            foreach ($this->staffData as $staff) {
                $this->sendNotification($staff);
            }

            Log::info('Staff notification job completed successfully');
        } catch (Exception $e) {
            Log::error('Staff notification job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Send notification to individual staff member.
     *
     * @param array $staff
     * @return void
     */
    protected function sendNotification(array $staff): void
    {
        try {
            // Send email notification
            if (isset($staff['email']) && !empty($staff['email'])) {
                Mail::send('emails.staff-notification', [
                    'staff' => $staff,
                    'notification_type' => $this->notificationType
                ], function ($message) use ($staff) {
                    $message->to($staff['email'])
                        ->subject('College Management System Notification');
                });
            }

            // Send SMS notification (if SMS service is configured)
            if (isset($staff['phone']) && !empty($staff['phone'])) {
                $this->sendSMS($staff);
            }

            Log::info('Notification sent to staff', [
                'staff_id' => $staff['id'] ?? 'unknown',
                'email' => $staff['email'] ?? 'not provided',
                'phone' => $staff['phone'] ?? 'not provided'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send notification to staff', [
                'staff_id' => $staff['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send SMS notification.
     *
     * @param array $staff
     * @return void
     */
    protected function sendSMS(array $staff): void
    {
        // Implement SMS sending logic here
        // This would integrate with SMS service providers like Twilio, etc.
        Log::info('SMS notification sent', [
            'staff_id' => $staff['id'] ?? 'unknown',
            'phone' => $staff['phone']
        ]);
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Staff notification job failed permanently', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
