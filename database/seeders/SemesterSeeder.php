<?php

namespace Database\Seeders;

use App\Models\v1\Semester;
use App\Enums\v1\Status;
use App\Models\v1\Session;
use Illuminate\Database\Seeder;

/**
 * SemesterSeeder - Version 1
 *
 * Seeds the semesters table with realistic semester data.
 * This seeder creates semesters for different academic years with proper relationships.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = Session::all();
        $semesters = [];

        foreach ($sessions as $session) {
            // Create semesters for each academic session
            $semesters[] = [

                'name' => 'Fall Semester ' . $session->name,
                'code' => 'FALL-01' . $session->name,
                'academic_year' => 2025,
                'start_date' => $session->start_date,
                'end_date' => date('Y-m-d', strtotime($session->start_date . ' + 4 months')),
                'is_current' => $session->is_current,
                'description' => 'Fall semester of ' . $session->name,
                'status' => $session->status,
            ];

            $semesters[] = [

                'name' => 'Spring Semester ' . $session->name,
                'code' => 'SPRING-' . $session->name,
                'academic_year' => 2021,
                'start_date' => date('Y-m-d', strtotime($session->start_date . ' + 5 months')),
                'end_date' => date('Y-m-d', strtotime($session->start_date . ' + 8 months')),
                'is_current' => false,
                'description' => 'Spring semester of ' . $session->name,
                'status' => $session->status,
            ];

            $semesters[] = [

                'name' => 'Summer Semester ' . $session->name,
                'code' => 'SUMMER-' . $session->name,
                'academic_year' => 2024,
                'start_date' => date('Y-m-d', strtotime($session->start_date . ' + 9 months')),
                'end_date' => $session->end_date,
                'is_current' => false,
                'description' => 'Summer semester of ' . $session->name,
                'status' => $session->status,
            ];
        }

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }

        $this->command->info('Created ' . count($semesters) . ' semesters successfully!');
    }
}
