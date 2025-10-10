<?php

namespace Database\Seeders;

use App\Enums\v1\Status;
use App\Models\v1\Faculty;
use Illuminate\Database\Seeder;

/**
 * FacultySeeder - Version 1
 *
 * Seeds the faculties table with realistic academic faculty data.
 * This seeder creates various faculties with real-world academic departments.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'name' => 'Faculty of Engineering and Technology',
                'code' => 'FET',
                'description' => 'Leading faculty in engineering education with state-of-the-art laboratories and research facilities.',
                'dean_name' => 'Dr. Sarah Johnson',
                'dean_email' => 'sarah.johnson@college.edu',
                'dean_phone' => '+1-555-0101',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Computer Science and Information Technology',
                'code' => 'FCSIT',
                'description' => 'Cutting-edge computer science programs with focus on AI, cybersecurity, and software engineering.',
                'dean_name' => 'Prof. Michael Chen',
                'dean_email' => 'michael.chen@college.edu',
                'dean_phone' => '+1-555-0102',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Business Administration',
                'code' => 'FBA',
                'description' => 'Comprehensive business education preparing students for leadership roles in modern organizations.',
                'dean_name' => 'Dr. Emily Rodriguez',
                'dean_email' => 'emily.rodriguez@college.edu',
                'dean_phone' => '+1-555-0103',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Medicine and Health Sciences',
                'code' => 'FMHS',
                'description' => 'Excellence in medical education with modern clinical facilities and research programs.',
                'dean_name' => 'Dr. James Wilson',
                'dean_email' => 'james.wilson@college.edu',
                'dean_phone' => '+1-555-0104',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Arts and Humanities',
                'code' => 'FAH',
                'description' => 'Diverse programs in literature, history, philosophy, and creative arts.',
                'dean_name' => 'Prof. Lisa Thompson',
                'dean_email' => 'lisa.thompson@college.edu',
                'dean_phone' => '+1-555-0105',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Science',
                'code' => 'FS',
                'description' => 'Advanced scientific education in physics, chemistry, biology, and mathematics.',
                'dean_name' => 'Dr. Robert Anderson',
                'dean_email' => 'robert.anderson@college.edu',
                'dean_phone' => '+1-555-0106',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Education',
                'code' => 'FE',
                'description' => 'Preparing future educators with innovative teaching methods and pedagogical research.',
                'dean_name' => 'Dr. Maria Garcia',
                'dean_email' => 'maria.garcia@college.edu',
                'dean_phone' => '+1-555-0107',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Law',
                'code' => 'FL',
                'description' => 'Comprehensive legal education with focus on modern legal practice and jurisprudence.',
                'dean_name' => 'Prof. David Brown',
                'dean_email' => 'david.brown@college.edu',
                'dean_phone' => '+1-555-0108',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Architecture and Design',
                'code' => 'FAD',
                'description' => 'Creative design education with emphasis on sustainable architecture and urban planning.',
                'dean_name' => 'Dr. Anna Lee',
                'dean_email' => 'anna.lee@college.edu',
                'dean_phone' => '+1-555-0109',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Social Sciences',
                'code' => 'FSS',
                'description' => 'Interdisciplinary social science programs covering psychology, sociology, and political science.',
                'dean_name' => 'Prof. Kevin Taylor',
                'dean_email' => 'kevin.taylor@college.edu',
                'dean_phone' => '+1-555-0110',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Agriculture',
                'code' => 'FA',
                'description' => 'Modern agricultural education with focus on sustainable farming and food security.',
                'dean_name' => 'Dr. Jennifer White',
                'dean_email' => 'jennifer.white@college.edu',
                'dean_phone' => '+1-555-0111',
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Faculty of Pharmacy',
                'code' => 'FP',
                'description' => 'Comprehensive pharmaceutical education with modern laboratory facilities.',
                'dean_name' => 'Dr. Thomas Miller',
                'dean_email' => 'thomas.miller@college.edu',
                'dean_phone' => '+1-555-0112',
                'status' => Status::ACTIVE->value,
            ],
        ];

        foreach ($faculties as $faculty) {
            Faculty::query()->create($faculty);
        }

        $this->command->info('Created ' . count($faculties) . ' faculties successfully!');
    }
}
