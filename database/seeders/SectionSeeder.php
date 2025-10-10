<?php

namespace Database\Seeders;

use App\Enums\v1\Status;
use App\Models\v1\Batch;
use App\Models\v1\Section;
use Illuminate\Database\Seeder;

/**
 * SectionSeeder - Version 1
 *
 * Seeds the sections table with realistic section data.
 * This seeder creates sections for different batches with proper relationships.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = Batch::all();
        $sections = [];

        foreach ($batches as $batch) {
            // Create 2-4 sections per batch
            $sectionCount = rand(2, 4);

            for ($i = 1; $i <= $sectionCount; $i++) {
                $sectionNames = ['A', 'B', 'C', 'D'];
                $sectionName = $sectionNames[$i - 1] ?? 'A';

                $sections[] = [
                    'batch_id' => $batch->id,
                    'name' => 'Section ' . $sectionName,
                    'code' => $batch->code . '-S' . $sectionName,
                    'seat' => rand(20, 40),
                    'description' => 'Section ' . $sectionName . ' of ' . $batch->name,
                    'sort_order' => $i,
                    'status' => Status::ACTIVE->value,
                ];
            }
        }

        foreach ($sections as $section) {
            Section::create($section);
        }

        $this->command->info('Created ' . count($sections) . ' sections successfully!');
    }
}
