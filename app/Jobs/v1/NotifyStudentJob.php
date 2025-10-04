<?php

namespace App\Jobs\v1;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * NotifyStudentJob - Version 1
 *
 * Job for sending notifications to students.
 * This job handles background processing of student notifications.
 *
 * @package App\Jobs\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class NotifyStudentJob implements ShouldQueue
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
     * The student data for notification.
     *
     * @var array
     */
    protected $studentData;

    /**
     * The notification type.
     *
     * @var string
     */
    protected $notificationType;

    /**
     * Create a new job instance.
     *
     * @param array $studentData
     * @param string $notificationType
     */
    public function __construct(array $studentData, string $notificationType = 'general')
    {
        $this->studentData = $studentData;
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
            Log::info('Starting student notification job', [
                'student_count' => count($this->studentData),
                'notification_type' => $this->notificationType
            ]);

            foreach ($this->studentData as $student) {
                $this->sendNotification($student);
            }

            Log::info('Student notification job completed successfully');
        } catch (Exception $e) {
            Log::error('Student notification job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Send notification to individual student.
     *
     * @param array $student
     * @return void
     */
    protected function sendNotification(array $student): void
    {
        try {
            // Send email notification
            if (isset($student['email']) && !empty($student['email'])) {
                Mail::send('emails.student-notification', [
                    'student' => $student,
                    'notification_type' => $this->notificationType
                ], function ($message) use ($student) {
                    $message->to($student['email'])
                        ->subject('College Management System Notification');
                });
            }

            // Send SMS notification (if SMS service is configured)
            if (isset($student['phone']) && !empty($student['phone'])) {
                $this->sendSMS($student);
            }

            Log::info('Notification sent to student', [
                'student_id' => $student['id'] ?? 'unknown',
                'email' => $student['email'] ?? 'not provided',
                'phone' => $student['phone'] ?? 'not provided'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send notification to student', [
                'student_id' => $student['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send SMS notification.
     *
     * @param array $student
     * @return void
     */
    protected function sendSMS(array $student): void
    {
        // Implement SMS sending logic here
        // This would integrate with SMS service providers like Twilio, etc.
        Log::info('SMS notification sent', [
            'student_id' => $student['id'] ?? 'unknown',
            'phone' => $student['phone']
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
        Log::error('Student notification job failed permanently', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
