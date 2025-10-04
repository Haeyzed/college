<?php

namespace App\Console\Commands\v1;

use Exception;
use Illuminate\Console\Command;
use App\Models\v1\Notice;

/**
 * NoticePublishDate Command - Version 1
 *
 * Command for publishing notices based on scheduled dates.
 * This command handles automatic publishing of notices.
 *
 * @package App\Console\Commands\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class NoticePublishDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:publish {--dry-run : Show what would be published without actually publishing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish notices based on their scheduled publish dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting notice publish process...');

        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No notices will be actually published');
        }

        try {
            $publishedCount = $this->publishNotices($dryRun);

            $this->info("Notice publish process completed. Published: {$publishedCount} notices");

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Notice publish process failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Publish notices based on publish date.
     *
     * @param bool $dryRun
     * @return int
     */
    protected function publishNotices(bool $dryRun): int
    {
        $this->info('Processing notices...');

        $noticesToPublish = Notice::where('status', 'draft')
            ->where('date', '<=', now())
            ->get();

        $publishedCount = 0;

        foreach ($noticesToPublish as $notice) {
            if ($dryRun) {
                $this->line("Would publish notice: {$notice->title} (ID: {$notice->id})");
            } else {
                $notice->update(['status' => 'published']);
                $this->line("Published notice: {$notice->title} (ID: {$notice->id})");
            }
            $publishedCount++;
        }

        $this->info("Notices processed: {$publishedCount} items");
        return $publishedCount;
    }
}
