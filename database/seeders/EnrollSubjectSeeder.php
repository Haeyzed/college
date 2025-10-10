<?php

namespace Database\Seeders;

use App\Enums\v1\Status;
use App\Models\v1\EnrollSubject;
use App\Models\v1\Program;
use App\Models\v1\Section;
use App\Models\v1\Semester;
use App\Models\v1\Subject;
use Illuminate\Database\Seeder;

/**
 * EnrollSubjectSeeder - Version 1
 *
 * Seeds the enroll_subjects table with realistic enrollment data.
 * This seeder creates enroll subjects with proper program-semester-section relationships.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class EnrollSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = Program::all();
        $semesters = Semester::where('status', Status::ACTIVE->value)->get();
        $sections = Section::where('status', Status::ACTIVE->value)->get();
        $subjects = Subject::where('status', Status::ACTIVE->value)->get();

        $enrollSubjects = [];

        // Create enroll subjects for each program-semester-section combination
        foreach ($programs as $program) {
            foreach ($semesters as $semester) {
                // Get sections for this program's batches
                $programSections = $sections->where('batch.program_id', $program->id);

                foreach ($programSections as $section) {
                    // Get relevant subjects for this program
                    $programSubjects = $this->getSubjectsForProgram($program, $subjects);

                    if (!empty($programSubjects)) {
                        $enrollSubject = EnrollSubject::firstOrCreate(
                            [
                                'program_id' => $program->id,
                                'semester_id' => $semester->id,
                                'section_id' => $section->id,
                            ],
                            [
                                'program_id' => $program->id,
                                'semester_id' => $semester->id,
                                'section_id' => $section->id,
                                'status' => Status::ACTIVE->value,
                            ]
                        );

                        // Attach subjects to this enroll subject
                        $enrollSubject->subjects()->sync($programSubjects);

                        $enrollSubjects[] = $enrollSubject;
                    }
                }
            }
        }

        $this->command->info('Created ' . count($enrollSubjects) . ' enroll subjects successfully!');
    }

    /**
     * Get relevant subjects for a specific program based on program type.
     */
    private function getSubjectsForProgram($program, $subjects)
    {
        $subjectIds = [];

        // Computer Science Programs
        if (str_contains($program->name, 'Computer Science') || str_contains($program->name, 'Software Engineering')) {
            $csSubjects = $subjects->whereIn('code', ['CS101', 'CS201', 'CS301', 'CS401', 'CS402']);
            $subjectIds = array_merge($subjectIds, $csSubjects->pluck('id')->toArray());
        }

        // Engineering Programs
        if (str_contains($program->name, 'Engineering')) {
            $engSubjects = $subjects->whereIn('code', ['EM101', 'EM201', 'EM301']);
            $subjectIds = array_merge($subjectIds, $engSubjects->pluck('id')->toArray());
        }

        // Business Programs
        if (str_contains($program->name, 'Business') || str_contains($program->name, 'Accounting')) {
            $busSubjects = $subjects->whereIn('code', ['BM101', 'BM201', 'BM301']);
            $subjectIds = array_merge($subjectIds, $busSubjects->pluck('id')->toArray());
        }

        // Medicine Programs
        if (str_contains($program->name, 'Medicine') || str_contains($program->name, 'Nursing')) {
            $medSubjects = $subjects->whereIn('code', ['AN101', 'PHY101']);
            $subjectIds = array_merge($subjectIds, $medSubjects->pluck('id')->toArray());
        }

        // Arts Programs
        if (str_contains($program->name, 'English') || str_contains($program->name, 'History')) {
            $artsSubjects = $subjects->whereIn('code', ['EN101', 'HI101']);
            $subjectIds = array_merge($subjectIds, $artsSubjects->pluck('id')->toArray());
        }

        // Science Programs
        if (str_contains($program->name, 'Physics') || str_contains($program->name, 'Chemistry')) {
            $sciSubjects = $subjects->whereIn('code', ['PH101', 'CH101', 'MT101']);
            $subjectIds = array_merge($subjectIds, $sciSubjects->pluck('id')->toArray());
        }

        // Add common subjects for all programs
        $commonSubjects = $subjects->whereIn('code', ['EN101', 'MT101']);
        $subjectIds = array_merge($subjectIds, $commonSubjects->pluck('id')->toArray());

        return array_unique($subjectIds);
    }
}
