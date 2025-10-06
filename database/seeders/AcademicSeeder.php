<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * AcademicSeeder - Version 1
 *
 * Master seeder that runs all academic-related seeders in the correct order.
 * This seeder ensures proper foreign key relationships are maintained.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Academic System Seeding...');

        // Seed faculties first (required for foreign keys)
        $this->command->info('Seeding Faculties...');
        $this->call(FacultySeeder::class);

        // Seed academic sessions (required for semesters)
        $this->command->info('Seeding Academic Sessions...');
        $this->call(AcademicSessionSeeder::class);

        // Seed semesters (depends on academic sessions)
        $this->command->info('Seeding Semesters...');
        $this->call(SemesterSeeder::class);

        // Seed programs (depends on faculties)
        $this->command->info('Seeding Programs...');
        $this->call(ProgramSeeder::class);

        // Seed batches (depends on programs)
        $this->command->info('Seeding Batches...');
        $this->call(BatchSeeder::class);

        // Seed sections (depends on batches)
        $this->command->info('Seeding Sections...');
        $this->call(SectionSeeder::class);

        // Seed subjects (independent)
        $this->command->info('Seeding Subjects...');
        $this->call(SubjectSeeder::class);

        // Seed classrooms (independent)
        $this->command->info('Seeding Classrooms...');
        $this->call(ClassRoomSeeder::class);

        // Seed enroll subjects (depends on programs, semesters, sections, and subjects)
        $this->command->info('Seeding Enroll Subjects...');
        $this->call(EnrollSubjectSeeder::class);

        $this->command->info('Academic System Seeding Completed Successfully!');
    }
}
