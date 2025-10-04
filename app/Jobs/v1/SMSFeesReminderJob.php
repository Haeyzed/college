<?php

namespace App\Jobs\v1;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\v1\Fee;
use App\Models\v1\StudentEnroll;
use Throwable;

/**
 * SMSFeesReminderJob - Version 1
 *
 * Job for sending SMS reminders for overdue fees.
 * This job handles background processing of fee reminder notifications.
 *
 * @package App\Jobs\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SMSFeesReminderJob implements ShouldQueue
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
    public $timeout = 300;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            Log::info('Starting SMS fees reminder job');

            // Get all overdue fees
            $overdueFees = Fee::overdue()
                ->with(['studentEnroll.student'])
                ->get();

            $reminderCount = 0;

            foreach ($overdueFees as $fee) {
                if ($this->sendFeeReminder($fee)) {
                    $reminderCount++;
                }
            }

            Log::info('SMS fees reminder job completed', [
                'total_overdue_fees' => $overdueFees->count(),
                'reminders_sent' => $reminderCount
            ]);
        } catch (Exception $e) {
            Log::error('SMS fees reminder job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Send fee reminder to student.
     *
     * @param Fee $fee
     * @return bool
     */
    protected function sendFeeReminder(Fee $fee): bool
    {
        try {
            $student = $fee->studentEnroll->student;

            if (!$student || !$student->phone) {
                Log::warning('Student phone not available for fee reminder', [
                    'fee_id' => $fee->id,
                    'student_id' => $student->id ?? 'unknown'
                ]);
                return false;
            }

            $message = $this->buildReminderMessage($fee, $student);

            // Send SMS (implement actual SMS service integration)
            $this->sendSMS($student->phone, $message);

            Log::info('Fee reminder sent', [
                'fee_id' => $fee->id,
                'student_id' => $student->id,
                'phone' => $student->phone,
                'amount' => $fee->fee_amount
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to send fee reminder', [
                'fee_id' => $fee->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Build reminder message.
     *
     * @param Fee $fee
     * @param mixed $student
     * @return string
     */
    protected function buildReminderMessage(Fee $fee, $student): string
    {
        $daysOverdue = now()->diffInDays($fee->due_date);

        return "Dear {$student->first_name}, your fee of {$fee->fee_amount} is overdue by {$daysOverdue} days. Please pay immediately to avoid further penalties.";
    }

    /**
     * Send SMS message.
     *
     * @param string $phone
     * @param string $message
     * @return void
     */
    protected function sendSMS(string $phone, string $message): void
    {
        // Implement actual SMS service integration here
        // This would integrate with SMS service providers like Twilio, etc.
        Log::info('SMS sent', [
            'phone' => $phone,
            'message' => $message
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
        Log::error('SMS fees reminder job failed permanently', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
