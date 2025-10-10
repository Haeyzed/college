<?php

namespace Database\Seeders;

use App\Models\v1\Program;
use Illuminate\Database\Seeder;

/**
 * ProgramSeeder - Version 1
 *
 * Seeds the programs table with realistic academic program data.
 * This seeder creates programs for different faculties with proper relationships.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $programs = [];
        foreach ($programs as $program) {
            Program::query()->create($program);
        }

        $this->command->info('Created ' . count($programs) . ' programs successfully!');
    }
}
