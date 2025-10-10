<?php

namespace Database\Seeders;

use App\Enums\v1\ClassType;
use App\Enums\v1\Status;
use App\Enums\v1\SubjectType;
use App\Models\v1\Subject;
use Illuminate\Database\Seeder;

/**
 * SubjectSeeder - Version 1
 *
 * Seeds the subjects table with realistic subject data.
 * This seeder creates subjects across different disciplines with proper categorization.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // Computer Science Subjects
            [
                'name' => 'Introduction to Programming',
                'code' => 'CS101',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Fundamental concepts of programming using Python and Java.',
                'learning_outcomes' => 'Students will learn basic programming concepts, data structures, and problem-solving techniques.',
                'prerequisites' => 'Basic mathematics knowledge',
                'sort_order' => 1,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Data Structures and Algorithms',
                'code' => 'CS201',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Study of fundamental data structures and algorithm design techniques.',
                'learning_outcomes' => 'Students will understand various data structures and learn to analyze algorithm complexity.',
                'prerequisites' => 'Introduction to Programming',
                'sort_order' => 2,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Database Management Systems',
                'code' => 'CS301',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Comprehensive study of database design, implementation, and management.',
                'learning_outcomes' => 'Students will learn database design, SQL, and database administration.',
                'prerequisites' => 'Data Structures and Algorithms',
                'sort_order' => 3,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Software Engineering',
                'code' => 'CS401',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Software development lifecycle, methodologies, and project management.',
                'learning_outcomes' => 'Students will learn software development processes and project management techniques.',
                'prerequisites' => 'Database Management Systems',
                'sort_order' => 4,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Web Development',
                'code' => 'CS402',
                'credit_hours' => 3,
                'subject_type' => SubjectType::ELECTIVE->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Modern web development using HTML, CSS, JavaScript, and frameworks.',
                'learning_outcomes' => 'Students will learn front-end and back-end web development technologies.',
                'prerequisites' => 'Introduction to Programming',
                'sort_order' => 5,
                'status' => Status::ACTIVE->value,
            ],

            // Engineering Subjects
            [
                'name' => 'Engineering Mathematics',
                'code' => 'EM101',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::THEORY->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Advanced mathematics for engineering applications.',
                'learning_outcomes' => 'Students will master calculus, linear algebra, and differential equations.',
                'prerequisites' => 'High school mathematics',
                'sort_order' => 6,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Engineering Mechanics',
                'code' => 'EM201',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Study of forces, motion, and equilibrium in engineering systems.',
                'learning_outcomes' => 'Students will understand statics and dynamics principles.',
                'prerequisites' => 'Engineering Mathematics',
                'sort_order' => 7,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Thermodynamics',
                'code' => 'EM301',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Study of heat, work, and energy in engineering systems.',
                'learning_outcomes' => 'Students will understand thermodynamic laws and their applications.',
                'prerequisites' => 'Engineering Mechanics',
                'sort_order' => 8,
                'status' => Status::ACTIVE->value,
            ],

            // Business Subjects
            [
                'name' => 'Principles of Management',
                'code' => 'BM101',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::THEORY->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Fundamental concepts of management and organizational behavior.',
                'learning_outcomes' => 'Students will learn management principles and leadership skills.',
                'prerequisites' => 'None',
                'sort_order' => 9,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Financial Accounting',
                'code' => 'BM201',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Principles and practices of financial accounting.',
                'learning_outcomes' => 'Students will learn accounting principles and financial statement preparation.',
                'prerequisites' => 'Basic mathematics',
                'sort_order' => 10,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Marketing Management',
                'code' => 'BM301',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Strategic marketing planning and implementation.',
                'learning_outcomes' => 'Students will learn marketing strategies and consumer behavior.',
                'prerequisites' => 'Principles of Management',
                'sort_order' => 11,
                'status' => Status::ACTIVE->value,
            ],

            // Science Subjects
            [
                'name' => 'General Physics',
                'code' => 'PH101',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Fundamental principles of physics including mechanics and thermodynamics.',
                'learning_outcomes' => 'Students will understand basic physics principles and their applications.',
                'prerequisites' => 'High school physics and mathematics',
                'sort_order' => 12,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'General Chemistry',
                'code' => 'CH101',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Fundamental concepts of chemistry including atomic structure and bonding.',
                'learning_outcomes' => 'Students will understand chemical principles and laboratory techniques.',
                'prerequisites' => 'High school chemistry',
                'sort_order' => 13,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Mathematics I',
                'code' => 'MT101',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::THEORY->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Calculus and analytical geometry.',
                'learning_outcomes' => 'Students will master differential and integral calculus.',
                'prerequisites' => 'High school mathematics',
                'sort_order' => 14,
                'status' => Status::ACTIVE->value,
            ],

            // Arts and Humanities Subjects
            [
                'name' => 'English Composition',
                'code' => 'EN101',
                'credit_hours' => 3,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::THEORY->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Development of writing skills and critical thinking.',
                'learning_outcomes' => 'Students will improve their writing and analytical skills.',
                'prerequisites' => 'High school English',
                'sort_order' => 15,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'World History',
                'code' => 'HI101',
                'credit_hours' => 3,
                'subject_type' => SubjectType::OPTIONAL->value,
                'class_type' => ClassType::THEORY->value,
                'total_marks' => 100.00,
                'passing_marks' => 50.00,
                'description' => 'Survey of world history from ancient to modern times.',
                'learning_outcomes' => 'Students will understand historical events and their significance.',
                'prerequisites' => 'None',
                'sort_order' => 16,
                'status' => Status::ACTIVE->value,
            ],

            // Medicine Subjects
            [
                'name' => 'Human Anatomy',
                'code' => 'AN101',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 60.00,
                'description' => 'Study of human body structure and organization.',
                'learning_outcomes' => 'Students will understand human anatomy and its clinical applications.',
                'prerequisites' => 'High school biology',
                'sort_order' => 17,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Physiology',
                'code' => 'PHY101',
                'credit_hours' => 4,
                'subject_type' => SubjectType::COMPULSORY->value,
                'class_type' => ClassType::BOTH->value,
                'total_marks' => 100.00,
                'passing_marks' => 60.00,
                'description' => 'Study of normal body functions and mechanisms.',
                'learning_outcomes' => 'Students will understand normal physiological processes.',
                'prerequisites' => 'Human Anatomy',
                'sort_order' => 18,
                'status' => Status::ACTIVE->value,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        $this->command->info('Created ' . count($subjects) . ' subjects successfully!');
    }
}
