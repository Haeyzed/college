<?php

namespace Database\Seeders;

use App\Enums\v1\Status;
use App\Models\v1\Book;
use App\Models\v1\BookCategory;
use Illuminate\Database\Seeder;

/**
 * BookSeeder - Version 1
 *
 * Seeds the books table with realistic book data from 2025.
 * This seeder creates comprehensive book entries for a college library.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookSeeder extends Seeder
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
        $refCategory = BookCategory::where('code', 'REF')->first();

        $books = [
            // Computer Science Books
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Introduction to Algorithms',
                'isbn' => '978-0-262-03384-8',
                'accession_number' => 'CS-001',
                'author' => 'Thomas H. Cormen',
                'publisher' => 'MIT Press',
                'edition' => '4th Edition',
                'publication_year' => 2022,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 15,
                'shelf_location' => 'CS-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive textbook on algorithms and data structures.',
                'note' => 'Core textbook for CS courses',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'isbn' => '978-0-13-235088-4',
                'accession_number' => 'CS-002',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'edition' => '1st Edition',
                'publication_year' => 2008,
                'language' => 'English',
                'price' => 47.99,
                'quantity' => 12,
                'shelf_location' => 'CS-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-2',
                'description' => 'A guide to writing clean, maintainable code.',
                'note' => 'Essential for software development',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'The Pragmatic Programmer',
                'isbn' => '978-0-201-61622-4',
                'accession_number' => 'CS-003',
                'author' => 'David Thomas',
                'publisher' => 'Addison-Wesley',
                'edition' => '20th Anniversary Edition',
                'publication_year' => 2019,
                'language' => 'English',
                'price' => 39.99,
                'quantity' => 10,
                'shelf_location' => 'CS-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-3',
                'description' => 'Your journey to mastery in software development.',
                'note' => 'Popular among developers',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'isbn' => '978-0-201-63361-0',
                'accession_number' => 'CS-004',
                'author' => 'Gang of Four',
                'publisher' => 'Addison-Wesley',
                'edition' => '1st Edition',
                'publication_year' => 1994,
                'language' => 'English',
                'price' => 59.99,
                'quantity' => 8,
                'shelf_location' => 'CS-A',
                'shelf_column' => 'C-2',
                'shelf_row' => 'R-1',
                'description' => 'Classic book on software design patterns.',
                'note' => 'Gang of Four patterns',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Artificial Intelligence: A Modern Approach',
                'isbn' => '978-0-13-461099-3',
                'accession_number' => 'CS-005',
                'author' => 'Stuart Russell',
                'publisher' => 'Pearson',
                'edition' => '4th Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 129.99,
                'quantity' => 6,
                'shelf_location' => 'CS-B',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive introduction to artificial intelligence.',
                'note' => 'AI textbook',
                'status' => Status::ACTIVE->value,
            ],

            // Mathematics Books
            [
                'book_category_id' => $mathCategory->id,
                'title' => 'Calculus: Early Transcendentals',
                'isbn' => '978-1-337-61392-7',
                'accession_number' => 'MATH-001',
                'author' => 'James Stewart',
                'publisher' => 'Cengage Learning',
                'edition' => '8th Edition',
                'publication_year' => 2016,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 20,
                'shelf_location' => 'MATH-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive calculus textbook with early transcendentals.',
                'note' => 'Standard calculus text',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $mathCategory->id,
                'title' => 'Linear Algebra and Its Applications',
                'isbn' => '978-0-321-98238-4',
                'accession_number' => 'MATH-002',
                'author' => 'David C. Lay',
                'publisher' => 'Pearson',
                'edition' => '6th Edition',
                'publication_year' => 2021,
                'language' => 'English',
                'price' => 149.99,
                'quantity' => 15,
                'shelf_location' => 'MATH-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-2',
                'description' => 'Introduction to linear algebra with applications.',
                'note' => 'Linear algebra textbook',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $mathCategory->id,
                'title' => 'Introduction to Statistical Learning',
                'isbn' => '978-1-4614-7138-7',
                'accession_number' => 'MATH-003',
                'author' => 'Gareth James',
                'publisher' => 'Springer',
                'edition' => '2nd Edition',
                'publication_year' => 2021,
                'language' => 'English',
                'price' => 79.99,
                'quantity' => 12,
                'shelf_location' => 'MATH-B',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Statistical learning methods and applications.',
                'note' => 'Statistics and machine learning',
                'status' => Status::ACTIVE->value,
            ],

            // Physics Books
            [
                'book_category_id' => $phyCategory->id,
                'title' => 'University Physics with Modern Physics',
                'isbn' => '978-0-13-515955-2',
                'accession_number' => 'PHY-001',
                'author' => 'Hugh D. Young',
                'publisher' => 'Pearson',
                'edition' => '15th Edition',
                'publication_year' => 2019,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 18,
                'shelf_location' => 'PHY-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive university physics textbook.',
                'note' => 'Standard physics text',
                'status' => Status::ACTIVE->value,
            ],
            [
                'book_category_id' => $phyCategory->id,
                'title' => 'Introduction to Quantum Mechanics',
                'isbn' => '978-1-107-18963-8',
                'accession_number' => 'PHY-002',
                'author' => 'David J. Griffiths',
                'publisher' => 'Cambridge University Press',
                'edition' => '3rd Edition',
                'publication_year' => 2018,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 8,
                'shelf_location' => 'PHY-B',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Introduction to quantum mechanics principles.',
                'note' => 'Quantum mechanics textbook',
                'status' => Status::ACTIVE->value,
            ],

            // Chemistry Books
            [
                'book_category_id' => $chemCategory->id,
                'title' => 'Organic Chemistry',
                'isbn' => '978-1-119-37076-1',
                'accession_number' => 'CHEM-001',
                'author' => 'David R. Klein',
                'publisher' => 'Wiley',
                'edition' => '4th Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 179.99,
                'quantity' => 14,
                'shelf_location' => 'CHEM-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive organic chemistry textbook.',
                'note' => 'Organic chemistry text',
                'status' => Status::ACTIVE->value,
            ],

            // Biology Books
            [
                'book_category_id' => $bioCategory->id,
                'title' => 'Campbell Biology',
                'isbn' => '978-0-134-09341-3',
                'accession_number' => 'BIO-001',
                'author' => 'Jane B. Reece',
                'publisher' => 'Pearson',
                'edition' => '12th Edition',
                'publication_year' => 2021,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 16,
                'shelf_location' => 'BIO-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive biology textbook.',
                'note' => 'Standard biology text',
                'status' => Status::ACTIVE->value,
            ],

            // Engineering Books
            [
                'book_category_id' => $engCategory->id,
                'title' => 'Mechanics of Materials',
                'isbn' => '978-0-13-431965-0',
                'accession_number' => 'ENG-001',
                'author' => 'Russell C. Hibbeler',
                'publisher' => 'Pearson',
                'edition' => '10th Edition',
                'publication_year' => 2017,
                'language' => 'English',
                'price' => 149.99,
                'quantity' => 12,
                'shelf_location' => 'ENG-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Mechanics of materials for engineering students.',
                'note' => 'Mechanical engineering text',
                'status' => Status::ACTIVE->value,
            ],

            // Business Administration Books
            [
                'book_category_id' => $baCategory->id,
                'title' => 'Principles of Marketing',
                'isbn' => '978-0-13-449251-3',
                'accession_number' => 'BA-001',
                'author' => 'Philip Kotler',
                'publisher' => 'Pearson',
                'edition' => '17th Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 159.99,
                'quantity' => 10,
                'shelf_location' => 'BA-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive marketing principles.',
                'note' => 'Marketing textbook',
                'status' => Status::ACTIVE->value,
            ],

            // Economics Books
            [
                'book_category_id' => $econCategory->id,
                'title' => 'Principles of Economics',
                'isbn' => '978-1-305-58512-6',
                'accession_number' => 'ECON-001',
                'author' => 'N. Gregory Mankiw',
                'publisher' => 'Cengage Learning',
                'edition' => '8th Edition',
                'publication_year' => 2018,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 12,
                'shelf_location' => 'ECON-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Introduction to economic principles.',
                'note' => 'Economics textbook',
                'status' => Status::ACTIVE->value,
            ],

            // Literature Books
            [
                'book_category_id' => $litCategory->id,
                'title' => 'The Great Gatsby',
                'isbn' => '978-0-7432-7356-5',
                'accession_number' => 'LIT-001',
                'author' => 'F. Scott Fitzgerald',
                'publisher' => 'Scribner',
                'edition' => 'Reissue Edition',
                'publication_year' => 2004,
                'language' => 'English',
                'price' => 12.99,
                'quantity' => 8,
                'shelf_location' => 'LIT-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Classic American novel.',
                'note' => 'American literature',
                'status' => Status::ACTIVE->value,
            ],

            // History Books
            [
                'book_category_id' => $histCategory->id,
                'title' => 'A People\'s History of the United States',
                'isbn' => '978-0-06-196558-8',
                'accession_number' => 'HIST-001',
                'author' => 'Howard Zinn',
                'publisher' => 'Harper Perennial',
                'edition' => 'Updated Edition',
                'publication_year' => 2015,
                'language' => 'English',
                'price' => 18.99,
                'quantity' => 6,
                'shelf_location' => 'HIST-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Alternative perspective on US history.',
                'note' => 'US history',
                'status' => Status::ACTIVE->value,
            ],

            // Psychology Books
            [
                'book_category_id' => $psyCategory->id,
                'title' => 'Introduction to Psychology',
                'isbn' => '978-0-13-447380-2',
                'accession_number' => 'PSY-001',
                'author' => 'James W. Kalat',
                'publisher' => 'Cengage Learning',
                'edition' => '12th Edition',
                'publication_year' => 2017,
                'language' => 'English',
                'price' => 179.99,
                'quantity' => 10,
                'shelf_location' => 'PSY-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive introduction to psychology.',
                'note' => 'Psychology textbook',
                'status' => Status::ACTIVE->value,
            ],

            // Medicine Books
            [
                'book_category_id' => $medCategory->id,
                'title' => 'Gray\'s Anatomy for Students',
                'isbn' => '978-0-323-39304-1',
                'accession_number' => 'MED-001',
                'author' => 'Richard L. Drake',
                'publisher' => 'Elsevier',
                'edition' => '4th Edition',
                'publication_year' => 2019,
                'language' => 'English',
                'price' => 89.99,
                'quantity' => 8,
                'shelf_location' => 'MED-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Student-friendly anatomy textbook.',
                'note' => 'Medical anatomy',
                'status' => Status::ACTIVE->value,
            ],

            // Law Books
            [
                'book_category_id' => $lawCategory->id,
                'title' => 'Constitutional Law',
                'isbn' => '978-1-4548-7654-3',
                'accession_number' => 'LAW-001',
                'author' => 'Erwin Chemerinsky',
                'publisher' => 'Wolters Kluwer',
                'edition' => '6th Edition',
                'publication_year' => 2019,
                'language' => 'English',
                'price' => 199.99,
                'quantity' => 6,
                'shelf_location' => 'LAW-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive constitutional law textbook.',
                'note' => 'Constitutional law',
                'status' => Status::ACTIVE->value,
            ],

            // Art & Design Books
            [
                'book_category_id' => $artCategory->id,
                'title' => 'The Art of Color',
                'isbn' => '978-0-471-28953-5',
                'accession_number' => 'ART-001',
                'author' => 'Johannes Itten',
                'publisher' => 'Wiley',
                'edition' => 'Revised Edition',
                'publication_year' => 1997,
                'language' => 'English',
                'price' => 24.99,
                'quantity' => 5,
                'shelf_location' => 'ART-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Classic work on color theory.',
                'note' => 'Color theory',
                'status' => Status::ACTIVE->value,
            ],

            // Reference Books
            [
                'book_category_id' => $refCategory->id,
                'title' => 'Oxford English Dictionary',
                'isbn' => '978-0-19-861186-8',
                'accession_number' => 'REF-001',
                'author' => 'Oxford University Press',
                'publisher' => 'Oxford University Press',
                'edition' => '2nd Edition',
                'publication_year' => 2020,
                'language' => 'English',
                'price' => 299.99,
                'quantity' => 3,
                'shelf_location' => 'REF-A',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'Comprehensive English dictionary.',
                'note' => 'Reference dictionary',
                'status' => Status::ACTIVE->value,
            ],

            // Some inactive books for testing
            [
                'book_category_id' => $csCategory->id,
                'title' => 'Outdated Programming Book',
                'isbn' => '978-0-123456-78-9',
                'accession_number' => 'CS-OLD-001',
                'author' => 'Old Author',
                'publisher' => 'Old Publisher',
                'edition' => '1st Edition',
                'publication_year' => 1990,
                'language' => 'English',
                'price' => 9.99,
                'quantity' => 0,
                'shelf_location' => 'CS-OLD',
                'shelf_column' => 'C-1',
                'shelf_row' => 'R-1',
                'description' => 'This book is outdated and no longer used.',
                'note' => 'Outdated technology',
                'status' => Status::INACTIVE->value,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
