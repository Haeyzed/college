<?php

namespace Database\Seeders;

use App\Models\v1\Batch;
use App\Models\v1\Program;
use App\Enums\v1\Status;
use Illuminate\Database\Seeder;

/**
 * BatchSeeder - Version 1
 *
 * Seeds the batches table with realistic batch data.
 * This seeder creates batches for different programs with proper relationships.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = Program::all();
        $batches = [];

        foreach ($programs as $program) {
            // Create multiple batches for each program
            $academicYears = ['2021-2022', '2022-2023', '2023-2024', '2024-2025'];
            
            foreach ($academicYears as $index => $academicYear) {
                $batchNumber = $index + 1;
                $startDate = date('Y-m-d', strtotime("2021-09-01 +{$index} years"));
                $endDate = date('Y-m-d', strtotime($startDate . ' +' . $program->duration_years . ' years'));

                $batches[] = [
                    'program_id' => $program->id,
                    'name' => $program->name . ' - Batch ' . $batchNumber,
                    'code' => $program->code . '-B' . $batchNumber,
                    'academic_year' => $academicYear,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'max_students' => rand(30, 60),
                    'description' => 'Batch ' . $batchNumber . ' of ' . $program->name . ' for academic year ' . $academicYear,
                    'sort_order' => $batchNumber,
                    'status' => $index < 2 ? Status::ACTIVE->value : Status::INACTIVE->value,
                ];
            }
        }

        foreach ($batches as $batch) {
            Batch::create($batch);
        }

        $this->command->info('Created ' . count($batches) . ' batches successfully!');
    }
}
