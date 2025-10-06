<?php

namespace Database\Seeders;

use App\Models\v1\Program;
use App\Models\v1\Faculty;
use App\Enums\v1\Status;
use App\Enums\v1\DegreeType;
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
        $faculties = Faculty::all();
        $programs = [];

        // Engineering Programs
        $engineeringFaculty = $faculties->where('code', 'FET')->first();
        if ($engineeringFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $engineeringFaculty->id,
                    'name' => 'Bachelor of Civil Engineering',
                    'code' => 'BCE',
                    'description' => 'Comprehensive civil engineering program covering structural design, construction management, and infrastructure development.',
                    'duration_years' => 4,
                    'total_credits' => 140,
                    'fee_amount' => 12000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics and physics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 1,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $engineeringFaculty->id,
                    'name' => 'Bachelor of Mechanical Engineering',
                    'code' => 'BME',
                    'description' => 'Advanced mechanical engineering program with focus on design, manufacturing, and automation.',
                    'duration_years' => 4,
                    'total_credits' => 140,
                    'fee_amount' => 12000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics and physics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 2,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $engineeringFaculty->id,
                    'name' => 'Master of Electrical Engineering',
                    'code' => 'MEE',
                    'description' => 'Graduate program in electrical engineering with specialization in power systems and electronics.',
                    'duration_years' => 2,
                    'total_credits' => 60,
                    'fee_amount' => 15000.00,
                    'degree_type' => DegreeType::MASTER->value,
                    'admission_requirements' => 'Bachelor degree in electrical engineering, minimum GPA 3.5',
                    'is_registration_open' => true,
                    'sort_order' => 3,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        // Computer Science Programs
        $csFaculty = $faculties->where('code', 'FCSIT')->first();
        if ($csFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $csFaculty->id,
                    'name' => 'Bachelor of Computer Science',
                    'code' => 'BCS',
                    'description' => 'Comprehensive computer science program covering programming, algorithms, and software development.',
                    'duration_years' => 4,
                    'total_credits' => 130,
                    'fee_amount' => 11000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 4,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $csFaculty->id,
                    'name' => 'Bachelor of Software Engineering',
                    'code' => 'BSE',
                    'description' => 'Specialized program in software engineering with focus on system design and development.',
                    'duration_years' => 4,
                    'total_credits' => 135,
                    'fee_amount' => 11500.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 5,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $csFaculty->id,
                    'name' => 'Master of Data Science',
                    'code' => 'MDS',
                    'description' => 'Advanced program in data science covering machine learning, statistics, and big data analytics.',
                    'duration_years' => 2,
                    'total_credits' => 60,
                    'fee_amount' => 14000.00,
                    'degree_type' => DegreeType::MASTER->value,
                    'admission_requirements' => 'Bachelor degree in computer science or related field, minimum GPA 3.5',
                    'is_registration_open' => true,
                    'sort_order' => 6,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        // Business Programs
        $businessFaculty = $faculties->where('code', 'FBA')->first();
        if ($businessFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $businessFaculty->id,
                    'name' => 'Bachelor of Business Administration',
                    'code' => 'BBA',
                    'description' => 'Comprehensive business administration program covering management, marketing, and finance.',
                    'duration_years' => 4,
                    'total_credits' => 120,
                    'fee_amount' => 10000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma, minimum GPA 2.5',
                    'is_registration_open' => true,
                    'sort_order' => 7,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $businessFaculty->id,
                    'name' => 'Master of Business Administration',
                    'code' => 'MBA',
                    'description' => 'Advanced business administration program with focus on leadership and strategic management.',
                    'duration_years' => 2,
                    'total_credits' => 60,
                    'fee_amount' => 18000.00,
                    'degree_type' => DegreeType::MASTER->value,
                    'admission_requirements' => 'Bachelor degree, minimum GPA 3.0, work experience preferred',
                    'is_registration_open' => true,
                    'sort_order' => 8,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $businessFaculty->id,
                    'name' => 'Bachelor of Accounting',
                    'code' => 'BAC',
                    'description' => 'Specialized accounting program covering financial reporting, auditing, and taxation.',
                    'duration_years' => 4,
                    'total_credits' => 125,
                    'fee_amount' => 10500.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics, minimum GPA 2.8',
                    'is_registration_open' => true,
                    'sort_order' => 9,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        // Medicine Programs
        $medicineFaculty = $faculties->where('code', 'FMHS')->first();
        if ($medicineFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $medicineFaculty->id,
                    'name' => 'Doctor of Medicine',
                    'code' => 'MD',
                    'description' => 'Comprehensive medical program preparing students for medical practice.',
                    'duration_years' => 6,
                    'total_credits' => 200,
                    'fee_amount' => 25000.00,
                    'degree_type' => DegreeType::PHD->value,
                    'admission_requirements' => 'High school diploma with biology, chemistry, physics, minimum GPA 3.5',
                    'is_registration_open' => true,
                    'sort_order' => 10,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $medicineFaculty->id,
                    'name' => 'Bachelor of Nursing',
                    'code' => 'BN',
                    'description' => 'Nursing program preparing students for professional nursing practice.',
                    'duration_years' => 4,
                    'total_credits' => 130,
                    'fee_amount' => 13000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with biology and chemistry, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 11,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        // Arts Programs
        $artsFaculty = $faculties->where('code', 'FAH')->first();
        if ($artsFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $artsFaculty->id,
                    'name' => 'Bachelor of English Literature',
                    'code' => 'BEL',
                    'description' => 'Comprehensive study of English literature from classical to contemporary works.',
                    'duration_years' => 4,
                    'total_credits' => 120,
                    'fee_amount' => 9000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with English, minimum GPA 2.5',
                    'is_registration_open' => true,
                    'sort_order' => 12,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $artsFaculty->id,
                    'name' => 'Bachelor of History',
                    'code' => 'BH',
                    'description' => 'Historical studies program covering world history, research methods, and historiography.',
                    'duration_years' => 4,
                    'total_credits' => 120,
                    'fee_amount' => 9000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma, minimum GPA 2.5',
                    'is_registration_open' => true,
                    'sort_order' => 13,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        // Science Programs
        $scienceFaculty = $faculties->where('code', 'FS')->first();
        if ($scienceFaculty) {
            $programs = array_merge($programs, [
                [
                    'faculty_id' => $scienceFaculty->id,
                    'name' => 'Bachelor of Physics',
                    'code' => 'BP',
                    'description' => 'Comprehensive physics program covering theoretical and experimental physics.',
                    'duration_years' => 4,
                    'total_credits' => 130,
                    'fee_amount' => 11000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with mathematics and physics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 14,
                    'status' => Status::ACTIVE->value,
                ],
                [
                    'faculty_id' => $scienceFaculty->id,
                    'name' => 'Bachelor of Chemistry',
                    'code' => 'BC',
                    'description' => 'Chemistry program covering organic, inorganic, and physical chemistry.',
                    'duration_years' => 4,
                    'total_credits' => 130,
                    'fee_amount' => 11000.00,
                    'degree_type' => DegreeType::BACHELOR->value,
                    'admission_requirements' => 'High school diploma with chemistry and mathematics, minimum GPA 3.0',
                    'is_registration_open' => true,
                    'sort_order' => 15,
                    'status' => Status::ACTIVE->value,
                ],
            ]);
        }

        foreach ($programs as $program) {
            Program::create($program);
        }

        $this->command->info('Created ' . count($programs) . ' programs successfully!');
    }
}
