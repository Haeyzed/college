<?php

namespace Database\Seeders;

use App\Enums\v1\Status;
use App\Models\v1\BookCategory;
use Illuminate\Database\Seeder;

/**
 * BookCategorySeeder - Version 1
 *
 * Seeds the book_categories table with realistic academic categories.
 * This seeder creates comprehensive book categories for a college library.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Computer Science',
                'code' => 'CS',
                'description' => 'Books related to computer science, programming, algorithms, and software engineering.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Mathematics',
                'code' => 'MATH',
                'description' => 'Mathematical textbooks, calculus, algebra, statistics, and applied mathematics.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Physics',
                'code' => 'PHY',
                'description' => 'Physics textbooks covering mechanics, thermodynamics, quantum physics, and modern physics.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Chemistry',
                'code' => 'CHEM',
                'description' => 'Chemistry books including organic, inorganic, physical, and analytical chemistry.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Biology',
                'code' => 'BIO',
                'description' => 'Biological sciences including molecular biology, genetics, ecology, and human anatomy.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Engineering',
                'code' => 'ENG',
                'description' => 'Engineering disciplines including mechanical, electrical, civil, and chemical engineering.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Business Administration',
                'code' => 'BA',
                'description' => 'Business and management books covering marketing, finance, operations, and strategy.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Economics',
                'code' => 'ECON',
                'description' => 'Economic theory, microeconomics, macroeconomics, and international economics.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Literature',
                'code' => 'LIT',
                'description' => 'Classic and contemporary literature, poetry, drama, and literary criticism.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'History',
                'code' => 'HIST',
                'description' => 'Historical books covering world history, regional history, and historical analysis.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Psychology',
                'code' => 'PSY',
                'description' => 'Psychology books covering cognitive psychology, social psychology, and clinical psychology.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Medicine',
                'code' => 'MED',
                'description' => 'Medical textbooks covering anatomy, physiology, pathology, and clinical medicine.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Law',
                'code' => 'LAW',
                'description' => 'Legal textbooks covering constitutional law, criminal law, civil law, and international law.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Art & Design',
                'code' => 'ART',
                'description' => 'Books on fine arts, graphic design, architecture, and art history.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Reference',
                'code' => 'REF',
                'description' => 'Reference materials including dictionaries, encyclopedias, and handbooks.',
                'status' => Status::ACTIVE->value,
            ],
            [
                'title' => 'Archived',
                'code' => 'ARCH',
                'description' => 'Outdated or discontinued book categories.',
                'status' => Status::INACTIVE->value,
            ],
        ];

        foreach ($categories as $category) {
            BookCategory::create($category);
        }
    }
}
