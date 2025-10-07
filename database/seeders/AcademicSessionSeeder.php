<?php

namespace Database\Seeders;

use App\Models\v1\AcademicSession;
use App\Enums\v1\Status;
use App\Models\v1\Session;
use Illuminate\Database\Seeder;

/**
 * AcademicSessionSeeder - Version 1
 *
 * Seeds the academic_sessions table with realistic academic year data.
 * This seeder creates academic sessions with proper date ranges and current session marking.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AcademicSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = [
            [
                'name' => 'Academic Year 2022-2023',
                'description' => 'Academic session for the year 2022-2023',
                'start_date' => '2022-09-01',
                'end_date' => '2023-08-31',
                'is_current' => false,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Academic Year 2023-2024',
                'description' => 'Academic session for the year 2023-2024',
                'start_date' => '2023-09-01',
                'end_date' => '2024-08-31',
                'is_current' => false,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Academic Year 2024-2025',
                'description' => 'Current academic session for the year 2024-2025',
                'start_date' => '2024-09-01',
                'end_date' => '2025-08-31',
                'is_current' => true,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Academic Year 2025-2026',
                'description' => 'Upcoming academic session for the year 2025-2026',
                'start_date' => '2025-09-01',
                'end_date' => '2026-08-31',
                'is_current' => false,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Academic Year 2021-2022',
                'description' => 'Previous academic session for the year 2021-2022',
                'start_date' => '2021-09-01',
                'end_date' => '2022-08-31',
                'is_current' => false,
                'status' => Status::INACTIVE->value,
            ],
        ];

        foreach ($sessions as $session) {
            Session::query()->create($session);
        }

        $this->command->info('Created ' . count($sessions) . ' academic sessions successfully!');
    }
}
