<?php

namespace App\Console\Commands\v1;

use App\Models\v1\Content;
use App\Models\v1\Notice;
use Exception;
use Illuminate\Console\Command;

/**
 * ContentPublishDate Command - Version 1
 *
 * Command for publishing content based on scheduled dates.
 * This command handles automatic publishing of content and notices.
 *
 * @package App\Console\Commands\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ContentPublishDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:publish {--dry-run : Show what would be published without actually publishing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish content and notices based on their scheduled publish dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Starting content publish process...');

        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No content will be actually published');
        }

        $publishedCount = 0;

        try {
            // Publish content
            $publishedCount += $this->publishContent($dryRun);

            // Publish notices
            $publishedCount += $this->publishNotices($dryRun);

            $this->info("Content publish process completed. Published: {$publishedCount} items");

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Content publish process failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Publish content based on publish date.
     *
     * @param bool $dryRun
     * @return int
     */
    protected function publishContent(bool $dryRun): int
    {
        $this->info('Processing content...');

        $contentToPublish = Content::where('status', 'draft')
            ->where('publish_date', '<=', now())
            ->get();

        $publishedCount = 0;

        foreach ($contentToPublish as $content) {
            if ($dryRun) {
                $this->line("Would publish content: {$content->title} (ID: {$content->id})");
            } else {
                $content->update(['status' => 'published']);
                $this->line("Published content: {$content->title} (ID: {$content->id})");
            }
            $publishedCount++;
        }

        $this->info("Content processed: {$publishedCount} items");
        return $publishedCount;
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
