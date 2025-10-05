<?php

namespace Database\Seeders;

use App\Models\v1\BookRequest;
use App\Models\v1\BookCategory;
use App\Enums\v1\BookRequestStatus;
use Illuminate\Database\Seeder;

/**
 * BookRequestSeeder - Version 1
 *
 * Seeds the book_requests table with realistic book request data.
 * This seeder creates comprehensive book request entries for a college library.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories for foreign key relationships
        $csCategory = BookCategory::where('code', 'CS')->first();
        $mathCategory = BookCategory::where('code', 'MATH')->first();
        $phyCategory = BookCategory::where('code', 'PHY')->first();
        $chemCategory = BookCategory::where('code', 'CHEM')->first();
        $bioCategory = BookCategory::where('code', 'BIO')->first();
        $engCategory = BookCategory::where('code', 'ENG')->first();
        $baCategory = BookCategory::where('code', 'BA')->first();
        $econCategory = BookCategory::where('code', 'ECON')->first();
        $litCategory = BookCategory::where('code', 'LIT')->first();
        $histCategory = BookCategory::where('code', 'HIST')->first();
        $psyCategory = BookCategory::where('code', 'PSY')->first();
        $medCategory = BookCategory::where('code', 'MED')->first();
        $lawCategory = BookCategory::where('code', 'LAW')->first();
        $artCategory = BookCategory::where('code', 'ART')->first();

        $bookRequests = [
            // Computer Science Requests
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Machine Learning: A Probabilistic Perspective',
                'isbn' => '978-0-262-01802-5',
                'accession_number' => 'CS-REQ-001',
                'author' => 'Kevin P. Murphy',
                'publisher' => 'MIT Press',
                'edition' => '1st Edition',
                'publication_year' => 2012,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 5,
                'requester_name' => 'Dr. Sarah Johnson',
                'requester_phone' => '+1-555-0123',
                'requester_email' => 'sarah.johnson@college.edu',
                'description' => 'Request for advanced machine learning textbook for graduate course in AI/ML. This book is essential for students working on probabilistic models and Bayesian methods.',
                'note' => 'High priority for Spring 2025 semester',
                'status' => BookRequestStatus::PENDING->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'System Design Interview',
                'isbn' => '978-1-733-9206-6',
                'accession_number' => 'CS-REQ-002',
                'author' => 'Alex Xu',
                'publisher' => 'Independently Published',
                'edition' => '2nd Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 39.99,
                'quantity' => 8,
                'requester_name' => 'Computer Science Department',
                'requester_phone' => '+1-555-0124',
                'requester_email' => 'cs.department@college.edu',
                'description' => 'Essential for students preparing for technical interviews. Covers distributed systems, scalability, and system design principles.',
                'note' => 'Career preparation resource',
                'status' => BookRequestStatus::APPROVED->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Database System Concepts',
                'isbn' => '978-0-07-802215-9',
                'accession_number' => 'CS-REQ-003',
                'author' => 'Abraham Silberschatz',
                'publisher' => 'McGraw-Hill',
                'edition' => '7th Edition',
                'publication_year' => 2019,
                'language' => 'English',
                'price' => 149.99,
                'quantity' => 12,
                'requester_name' => 'Prof. Michael Chen',
                'requester_phone' => '+1-555-0125',
                'requester_email' => 'michael.chen@college.edu',
                'description' => 'Core textbook for database systems course. Need updated edition with latest database technologies and concepts.',
                'note' => 'Required for CS 301 Database Systems',
                'status' => BookRequestStatus::IN_PROGRESS->value,
            ],

            // Mathematics Requests
            [
                'book_category_id' => $mathCategory->id,
                'title' => 'Advanced Calculus',
                'isbn' => '978-0-13-065265-2',
                'accession_number' => 'MATH-REQ-001',
                'author' => 'Patrick M. Fitzpatrick',
                'publisher' => 'Pearson',
                'edition' => '2nd Edition',
                'publication_year' => 2006,
                'language' => 'English',
                'price' => 129.99,
                'quantity' => 6,
                'requester_name' => 'Mathematics Department',
                'requester_phone' => '+1-555-0126',
                'requester_email' => 'math.department@college.edu',
                'description' => 'Advanced calculus textbook for upper-level mathematics courses. Covers multivariable calculus and analysis.',
                'note' => 'For MATH 401 Advanced Calculus',
                'status' => BookRequestStatus::PENDING->value,
            ],
            [
                'book_category_id' => $mathCategory->id,
                'title' => 'Numerical Analysis',
                'isbn' => '978-0-13-300653-7',
                'accession_number' => 'MATH-REQ-002',
                'author' => 'Richard L. Burden',
                'publisher' => 'Pearson',
                'edition' => '10th Edition',
                'publication_year' => 2016,
                'language' => 'English',
                'price' => 159.99,
                'quantity' => 8,
                'requester_name' => 'Dr. Lisa Wang',
                'requester_phone' => '+1-555-0127',
                'requester_email' => 'lisa.wang@college.edu',
                'description' => 'Comprehensive numerical analysis textbook for computational mathematics course.',
                'note' => 'Essential for computational methods',
                'status' => BookRequestStatus::APPROVED->value,
            ],

            // Physics Requests
            [
                'book_category_id' => $phyCategory->id,
                'title' => 'Classical Mechanics',
                'isbn' => '978-0-201-65702-9',
                'accession_number' => 'PHY-REQ-001',
                'author' => 'Herbert Goldstein',
                'publisher' => 'Addison-Wesley',
                'edition' => '3rd Edition',
                'publication_year' => 2001,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 10,
                'requester_name' => 'Physics Department',
                'requester_phone' => '+1-555-0128',
                'requester_email' => 'physics.department@college.edu',
                'description' => 'Classic textbook on classical mechanics for advanced physics students.',
                'note' => 'For PHY 301 Classical Mechanics',
                'status' => BookRequestStatus::PENDING->value,
            ],

            // Chemistry Requests
            [
                'book_category_id' => $chemCategory->id,
                'title' => 'Physical Chemistry',
                'isbn' => '978-0-13-420212-1',
                'accession_number' => 'CHEM-REQ-001',
                'author' => 'Peter Atkins',
                'publisher' => 'Oxford University Press',
                'edition' => '11th Edition',
                'publication_year' => 2017,
                'language' => 'English',
                'price' => 179.99,
                'quantity' => 8,
                'requester_name' => 'Dr. Robert Kim',
                'requester_phone' => '+1-555-0129',
                'requester_email' => 'robert.kim@college.edu',
                'description' => 'Comprehensive physical chemistry textbook for advanced chemistry courses.',
                'note' => 'Required for CHEM 401 Physical Chemistry',
                'status' => BookRequestStatus::IN_PROGRESS->value,
            ],

            // Biology Requests
            [
                'book_category_id' => $bioCategory->id,
                'title' => 'Molecular Biology of the Cell',
                'isbn' => '978-0-8153-4432-2',
                'accession_number' => 'BIO-REQ-001',
                'author' => 'Bruce Alberts',
                'publisher' => 'W. W. Norton & Company',
                'edition' => '6th Edition',
                'publication_year' => 2014,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 10,
                'requester_name' => 'Biology Department',
                'requester_phone' => '+1-555-0130',
                'requester_email' => 'biology.department@college.edu',
                'description' => 'Essential textbook for molecular biology and cell biology courses.',
                'note' => 'Core text for BIO 301 Cell Biology',
                'status' => BookRequestStatus::APPROVED->value,
            ],

            // Engineering Requests
            [
                'book_category_id' => $engCategory->id,
                'title' => 'Fundamentals of Electric Circuits',
                'isbn' => '978-0-07-352955-4',
                'accession_number' => 'ENG-REQ-001',
                'author' => 'Charles K. Alexander',
                'publisher' => 'McGraw-Hill',
                'edition' => '6th Edition',
                'publication_year' => 2016,
                'language' => 'English',
                'price' => 149.99,
                'quantity' => 15,
                'requester_name' => 'Electrical Engineering Department',
                'requester_phone' => '+1-555-0131',
                'requester_email' => 'ee.department@college.edu',
                'description' => 'Fundamental textbook for electrical circuits course.',
                'note' => 'Required for EE 201 Circuit Analysis',
                'status' => BookRequestStatus::PENDING->value,
            ],

            // Business Administration Requests
            [
                'book_category_id' => $baCategory->id,
                'title' => 'Strategic Management',
                'isbn' => '978-1-259-25354-1',
                'accession_number' => 'BA-REQ-001',
                'author' => 'Frank T. Rothaermel',
                'publisher' => 'McGraw-Hill',
                'edition' => '5th Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 179.99,
                'quantity' => 12,
                'requester_name' => 'Business School',
                'requester_phone' => '+1-555-0132',
                'requester_email' => 'business.school@college.edu',
                'description' => 'Comprehensive strategic management textbook for MBA program.',
                'note' => 'Core text for MBA 501 Strategic Management',
                'status' => BookRequestStatus::APPROVED->value,
            ],

            // Economics Requests
            [
                'book_category_id' => $econCategory->id,
                'title' => 'Intermediate Microeconomics',
                'isbn' => '978-0-393-12388-1',
                'accession_number' => 'ECON-REQ-001',
                'author' => 'Hal R. Varian',
                'publisher' => 'W. W. Norton & Company',
                'edition' => '9th Edition',
                'publication_year' => 2014,
                'language' => 'English',
                'price' => 129.99,
                'quantity' => 8,
                'requester_name' => 'Economics Department',
                'requester_phone' => '+1-555-0133',
                'requester_email' => 'economics.department@college.edu',
                'description' => 'Intermediate microeconomics textbook with mathematical approach.',
                'note' => 'For ECON 301 Intermediate Microeconomics',
                'status' => BookRequestStatus::PENDING->value,
            ],

            // Literature Requests
            [
                'book_category_id' => $litCategory->id,
                'title' => 'The Norton Anthology of World Literature',
                'isbn' => '978-0-393-26593-4',
                'accession_number' => 'LIT-REQ-001',
                'author' => 'Martin Puchner',
                'publisher' => 'W. W. Norton & Company',
                'edition' => '4th Edition',
                'publication_year' => 2018,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 6,
                'requester_name' => 'English Department',
                'requester_phone' => '+1-555-0134',
                'requester_email' => 'english.department@college.edu',
                'description' => 'Comprehensive anthology of world literature for comparative literature course.',
                'note' => 'For LIT 201 World Literature',
                'status' => BookRequestStatus::IN_PROGRESS->value,
            ],

            // History Requests
            [
                'book_category_id' => $histCategory->id,
                'title' => 'The Making of the Modern World',
                'isbn' => '978-0-393-12345-6',
                'accession_number' => 'HIST-REQ-001',
                'author' => 'John M. Roberts',
                'publisher' => 'W. W. Norton & Company',
                'edition' => '3rd Edition',
                'publication_year' => 2013,
                'language' => 'English',
                'price' => 79.99,
                'quantity' => 8,
                'requester_name' => 'History Department',
                'requester_phone' => '+1-555-0135',
                'requester_email' => 'history.department@college.edu',
                'description' => 'Comprehensive world history textbook for modern history course.',
                'note' => 'For HIST 301 Modern World History',
                'status' => BookRequestStatus::APPROVED->value,
            ],

            // Psychology Requests
            [
                'book_category_id' => $psyCategory->id,
                'title' => 'Abnormal Psychology',
                'isbn' => '978-1-260-57193-6',
                'accession_number' => 'PSY-REQ-001',
                'author' => 'Ronald J. Comer',
                'publisher' => 'Worth Publishers',
                'edition' => '10th Edition',
                'publication_year' => 2018,
                'language' => 'English',
                'price' => 159.99,
                'quantity' => 10,
                'requester_name' => 'Psychology Department',
                'requester_phone' => '+1-555-0136',
                'requester_email' => 'psychology.department@college.edu',
                'description' => 'Comprehensive textbook on abnormal psychology and mental disorders.',
                'note' => 'For PSY 301 Abnormal Psychology',
                'status' => BookRequestStatus::PENDING->value,
            ],

            // Medicine Requests
            [
                'book_category_id' => $medCategory->id,
                'title' => 'Harrison\'s Principles of Internal Medicine',
                'isbn' => '978-1-260-45647-4',
                'accession_number' => 'MED-REQ-001',
                'author' => 'J. Larry Jameson',
                'publisher' => 'McGraw-Hill',
                'edition' => '21st Edition',
                'publication_year' => 2022,
                'language' => 'English',
                'price' => 299.99,
                'quantity' => 4,
                'requester_name' => 'Medical School',
                'requester_phone' => '+1-555-0137',
                'requester_email' => 'medical.school@college.edu',
                'description' => 'Comprehensive internal medicine textbook for medical students.',
                'note' => 'Essential reference for medical students',
                'status' => BookRequestStatus::APPROVED->value,
            ],

            // Law Requests
            [
                'book_category_id' => $lawCategory->id,
                'title' => 'Criminal Law',
                'isbn' => '978-1-4548-7654-3',
                'accession_number' => 'LAW-REQ-001',
                'author' => 'Joshua Dressler',
                'publisher' => 'West Academic Publishing',
                'edition' => '7th Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 6,
                'requester_name' => 'Law School',
                'requester_phone' => '+1-555-0138',
                'requester_email' => 'law.school@college.edu',
                'description' => 'Comprehensive criminal law textbook for law students.',
                'note' => 'For LAW 201 Criminal Law',
                'status' => BookRequestStatus::PENDING->value,
            ],

            // Art & Design Requests
            [
                'book_category_id' => $artCategory->id,
                'title' => 'The Elements of Typographic Style',
                'isbn' => '978-0-88179-212-6',
                'accession_number' => 'ART-REQ-001',
                'author' => 'Robert Bringhurst',
                'publisher' => 'Hartley & Marks',
                'edition' => '4th Edition',
                'publication_year' => 2012,
                'language' => 'English',
                'price' => 29.99,
                'quantity' => 8,
                'requester_name' => 'Art Department',
                'requester_phone' => '+1-555-0139',
                'requester_email' => 'art.department@college.edu',
                'description' => 'Essential guide to typography for graphic design students.',
                'note' => 'For ART 201 Typography',
                'status' => BookRequestStatus::IN_PROGRESS->value,
            ],

            // Some rejected requests for testing
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Outdated Programming Language Book',
                'isbn' => '978-0-123456-78-9',
                'accession_number' => 'CS-REQ-REJECTED-001',
                'author' => 'Old Author',
                'publisher' => 'Old Publisher',
                'edition' => '1st Edition',
                'publication_year' => 1995,
                'language' => 'English',
                'price' => 9.99,
                'quantity' => 5,
                'requester_name' => 'Dr. Outdated',
                'requester_phone' => '+1-555-0140',
                'requester_email' => 'outdated@college.edu',
                'description' => 'Request for outdated programming book that is no longer relevant.',
                'note' => 'Outdated technology - not recommended',
                'status' => BookRequestStatus::REJECTED->value,
            ],
        ];

        foreach ($bookRequests as $bookRequest) {
            BookRequest::create($bookRequest);
        }
    }
}
