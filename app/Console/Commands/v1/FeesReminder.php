<?php

namespace App\Console\Commands\v1;

use Exception;
use Illuminate\Console\Command;
use App\Models\v1\Fee;
use App\Jobs\v1\SMSFeesReminderJob;
use Illuminate\Database\Eloquent\Collection;

/**
 * FeesReminder Command - Version 1
 *
 * Command for sending fee reminders to students.
 * This command handles automated fee reminder notifications.
 *
 * @package App\Console\Commands\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FeesReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fees:remind {--days=7 : Number of days before due date to send reminder} {--dry-run : Show what would be sent without actually sending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send fee reminders to students with overdue or upcoming due fees';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting fee reminder process...');

        $days = (int)$this->option('days');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No reminders will be actually sent');
        }

        try {
            // Get overdue fees
            $overdueFees = $this->getOverdueFees();
            $this->info("Found {$overdueFees->count()} overdue fees");

            // Get upcoming due fees
            $upcomingFees = $this->getUpcomingFees($days);
            $this->info("Found {$upcomingFees->count()} upcoming due fees");

            $totalFees = $overdueFees->count() + $upcomingFees->count();

            if ($totalFees === 0) {
                $this->info('No fees require reminders at this time.');
                return Command::SUCCESS;
            }

            if (!$dryRun) {
                // Dispatch job for overdue fees
                if ($overdueFees->count() > 0) {
                    SMSFeesReminderJob::dispatch($overdueFees->toArray(), 'overdue');
                    $this->info("Dispatched job for {$overdueFees->count()} overdue fees");
                }

                // Dispatch job for upcoming fees
                if ($upcomingFees->count() > 0) {
                    SMSFeesReminderJob::dispatch($upcomingFees->toArray(), 'upcoming');
                    $this->info("Dispatched job for {$upcomingFees->count()} upcoming fees");
                }
            } else {
                $this->line("Would send reminders for {$totalFees} fees");
            }

            $this->info("Fee reminder process completed successfully");

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Fee reminder process failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Get overdue fees.
     *
     * @return Collection
     */
    protected function getOverdueFees()
    {
        return Fee::overdue()
            ->with(['studentEnroll.student'])
            ->get();
    }

    /**
     * Get upcoming due fees.
     *
     * @param int $days
     * @return Collection
     */
    protected function getUpcomingFees(int $days)
    {
        $dueDate = now()->addDays($days);

        return Fee::where('status', 'unpaid')
            ->where('due_date', '<=', $dueDate)
            ->where('due_date', '>', now())
            ->with(['studentEnroll.student'])
            ->get();
    }
}
