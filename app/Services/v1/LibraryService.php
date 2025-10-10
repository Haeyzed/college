<?php

namespace App\Services\v1;

use App\Enums\v1\BookCategoryStatus;
use App\Enums\v1\IssueStatus;
use App\Imports\v1\BookImport;
use App\Models\v1\Book;
use App\Models\v1\BookCategory;
use App\Models\v1\BookRequest;
use App\Models\v1\IdCardSetting;
use App\Models\v1\IssueReturn;
use App\Traits\v1\FileUploader;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * LibraryService - Version 1
 *
 * Service for managing library operations in the College Management System.
 * This service handles books, book categories, and library-related business logic.
 *
 * @version 1.0.0
 *
 * @author Softmax Technologies
 */
class LibraryService
{
    use FileUploader;
    /*
    |--------------------------------------------------------------------------
    | Book Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all book-related operations including CRUD operations
    | for books, book search, and book filtering by category. Book management
    | includes creating, updating, deleting, and retrieving book information
    | with support for cover image handling, availability tracking, Excel import,
    | and comprehensive search capabilities.
    |
    */

    /**
     * Get a paginated list of books with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $bookCategoryId Filter by book category ID
     * @param string|null $status Filter by book status (active/inactive)
     * @param string|null $author Filter by author name
     * @param string|null $search Search term for book title, author, or ISBN
     * @param bool|null $available Filter by availability status
     * @return LengthAwarePaginator Paginated list of books
     */
    public function getBooks(int $perPage, ?int $bookCategoryId = null, ?string $status = null, ?string $author = null, ?string $search = null, ?bool $available = null): LengthAwarePaginator
    {
        $query = Book::with(['bookCategory', 'issues'])
            ->when($bookCategoryId, fn ($q) => $q->filterByBookCategory($bookCategoryId))
            ->when($status, fn ($q) => $q->filterByStatus($status))
            ->when($author, fn ($q) => $q->filterByAuthor($author))
            ->when($search, fn ($q) => $q->search($search))
            ->when($available !== null, fn ($q) => $q->filterByAvailability($available));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book by ID.
     *
     * @param int $id Book ID
     * @return Book Book model instance with relationships
     * @throws ModelNotFoundException When book is not found
     */
    public function getBookById(int $id): Book
    {
        return Book::with(['bookCategory', 'issues.member'])->findOrFail($id);
    }

    /**
     * Create a new book.
     *
     * @param array $data Book data including title, author, ISBN, cover image, etc.
     * @return Book Created book instance with category relationship
     * @throws Exception When creation fails
     */
    public function createBook(array $data): Book
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['cover_image_path']) && $data['cover_image_path']) {
                $data['cover_image_path'] = $this->uploadImage(
                    file: $data['cover_image_path'],
                    directory: 'books',
                    width: 100,
                    height: 150
                );
            }

            $book = Book::query()->create($data);

            return $book->load(['bookCategory']);
        });
    }

    /**
     * Update an existing book.
     *
     * @param int $id Book ID to update
     * @param array $data Updated book data including cover image handling
     * @return Book Updated book instance with category relationship
     * @throws ModelNotFoundException When book is not found
     * @throws Exception When update fails
     */
    public function updateBook(int $id, array $data): Book
    {
        return DB::transaction(function () use ($data, $id) {
            $book = Book::query()->findOrFail($id);
            if (isset($data['cover_image_path']) && $data['cover_image_path']) {
                if ($book->cover_image_path) {
                    $data['cover_image_path'] = $this->updateImage(
                        file: $data['cover_image_path'],
                        directory: 'books',
                        width: 100,
                        height: 150,
                        model: $book,
                        field: 'cover_image_path'
                    );
                } else {
                    $data['cover_image_path'] = $this->uploadImage(
                        file: $data['cover_image_path'],
                        directory: 'books',
                        width: 100,
                        height: 150
                    );
                }
            }

            $book->update($data);

            return $book->load(['bookCategory']);
        });
    }

    /**
     * Delete a book (Soft Delete).
     *
     * @param int $id Book ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When book is not found
     * @throws Exception When book has active issues
     */
    public function deleteBook(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $book = Book::query()->findOrFail($id);

            $activeIssues = IssueReturn::query()->where('book_id', $id)
                ->where('status', IssueStatus::ISSUED->value)
                ->count();

            if ($activeIssues > 0) {
                throw new Exception('Cannot delete book with active issues');
            }

            $book->delete();

            return true;
        });
    }

    /**
     * Force delete a book (Permanent Delete).
     *
     * @param int $id Book ID to permanently delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When book is not found
     * @throws Exception When book has active issues
     */
    public function forceDeleteBook(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $book = Book::query()->findOrFail($id);

            $activeIssues = IssueReturn::query()->where('book_id', $id)
                ->where('status', IssueStatus::ISSUED->value)
                ->count();

            if ($activeIssues > 0) {
                throw new Exception('Cannot force delete book with active issues');
            }

            $book->forceDelete();

            return true;
        });
    }

    /**
     * Bulk update book status.
     *
     * @param array $ids Array of book IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of books updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateBookStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Book::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete books (Soft Delete).
     *
     * @param array $ids Array of book IDs to delete
     * @return int Number of books successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteBooks(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $books = Book::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($books as $book) {
                $activeIssues = IssueReturn::query()->where('book_id', $book->id)
                    ->where('status', IssueStatus::ISSUED->value)
                    ->count();

                if ($activeIssues > 0) {
                    continue;
                }

                $book->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Bulk force delete books (Permanent Delete).
     *
     * @param array $ids Array of book IDs to permanently delete
     * @return int Number of books successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkForceDeleteBooks(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $books = Book::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($books as $book) {
                $activeIssues = IssueReturn::query()->where('book_id', $book->id)
                    ->where('status', IssueStatus::ISSUED->value)
                    ->count();

                if ($activeIssues > 0) {
                    continue;
                }

                $book->forceDelete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Import books from Excel file.
     *
     * @param UploadedFile $file Excel file containing book data
     * @param int $bookCategoryId Category ID to assign imported books
     * @return array Import result with success status and count
     * @throws Exception When import fails
     */
    public function importBooks(UploadedFile $file, int $bookCategoryId): array
    {
        try {
            $data = ['category' => $bookCategoryId];
            $import = new BookImport($data);
            Excel::import($import, $file);

            return [
                'success' => true,
                'message' => 'Books imported successfully',
                'data' => [
                    'imported_count' => $import->getRowCount() ?? 0,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Import failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Get import template for books.
     *
     * @return array Template structure with headers, sample data, and instructions
     */
    public function getBookImportTemplate(): array
    {
        return [
            'headers' => [
                'title', 'isbn', 'author', 'publisher', 'edition', 'publication_year', 'language',
                'price', 'quantity', 'accession_number', 'shelf_location', 'shelf_column', 'shelf_row',
                'description', 'note'
            ],
            'sample_data' => [
                ['Introduction to Programming', '978-0-123456-78-9', 'John Doe', 'Tech Publications', '2nd Edition', 2023, 'English', 29.99, 10, 'LMS-90021', 'Science-A', 'C-2', 'R-5', 'A comprehensive guide', 'Special edition'],
                ['Advanced Algorithms', '978-0-987654-32-1', 'Jane Smith', 'Academic Press', '1st Edition', 2022, 'English', 49.99, 5, 'LMS-90022', 'Math-B', 'C-1', 'R-1', 'Advanced programming concepts', null],
            ],
            'required_fields' => ['title', 'isbn', 'author', 'quantity'],
            'optional_fields' => [
                'publisher', 'edition', 'publication_year', 'language', 'price', 'accession_number',
                'shelf_location', 'shelf_column', 'shelf_row', 'description', 'note'
            ],
            'instructions' => [
                'title' => 'Book title (required)',
                'isbn' => 'ISBN number (required, must be unique)',
                'author' => 'Author name (required)',
                'publisher' => 'Publisher name (optional)',
                'edition' => 'Book edition (optional)',
                'publication_year' => 'Publication year (optional, numeric)',
                'language' => 'Book language (optional)',
                'price' => 'Book price (optional, numeric)',
                'quantity' => 'Available quantity (required, numeric)',
                'accession_number' => 'Book Accession Number (optional, unique)',
                'shelf_location' => 'Library Shelf Location (optional)',
                'shelf_column' => 'Library Shelf Column (optional)',
                'shelf_row' => 'Library Shelf Row (optional)',
                'description' => 'Book description (optional)',
                'note' => 'Additional notes (optional)',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Book Request Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all book request-related operations including CRUD
    | operations for book requests and request filtering. Book request management
    | includes creating, updating, deleting, and retrieving book request information
    | with support for cover image handling, status tracking, and comprehensive
    | filtering capabilities.
    |
    */

    /**
     * Get a paginated list of book requests with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param int|null $bookCategoryId Filter by book category ID
     * @param string|null $status Filter by request status (pending/in_progress/approved/rejected)
     * @param string|null $author Filter by author name
     * @param string|null $search Search term for book title, author, or requester
     * @param string|null $requester Filter by requester name
     * @return LengthAwarePaginator Paginated list of book requests
     */
    public function getBookRequests(int $perPage, ?int $bookCategoryId = null, ?string $status = null, ?string $author = null, ?string $search = null, ?string $requester = null): LengthAwarePaginator
    {
        $query = BookRequest::with(['bookCategory'])
            ->when($bookCategoryId, fn ($q) => $q->filterByBookCategory($bookCategoryId))
            ->when($status, fn ($q) => $q->filterByStatus($status))
            ->when($author, fn ($q) => $q->filterByAuthor($author))
            ->when($requester, fn ($q) => $q->filterByRequester($requester))
            ->when($search, fn ($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book request by ID.
     *
     * @param int $id Book request ID
     * @return BookRequest Book request model instance with relationships
     * @throws ModelNotFoundException When book request is not found
     */
    public function getBookRequestById(int $id): BookRequest
    {
        return BookRequest::with(['bookCategory'])->findOrFail($id);
    }

    /**
     * Create a new book request.
     *
     * @param array $data Book request data including title, author, cover image, etc.
     * @return BookRequest Created book request instance with category relationship
     * @throws Exception When creation fails
     */
    public function createBookRequest(array $data): BookRequest
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['cover_image_path']) && $data['cover_image_path']) {
                $data['cover_image_path'] = $this->uploadImage(
                    file: $data['cover_image_path'],
                    directory: 'book-requests',
                    width: 100,
                    height: 150
                );
            }

            $bookRequest = BookRequest::query()->create($data);

            return $bookRequest->load(['bookCategory']);
        });
    }

    /**
     * Update an existing book request.
     *
     * @param int $id Book request ID to update
     * @param array $data Updated book request data including cover image handling
     * @return BookRequest Updated book request instance with category relationship
     * @throws ModelNotFoundException When book request is not found
     * @throws Exception When update fails
     */
    public function updateBookRequest(int $id, array $data): BookRequest
    {
        return DB::transaction(function () use ($data, $id) {
            $bookRequest = BookRequest::query()->findOrFail($id);
            if (isset($data['cover_image_path']) && $data['cover_image_path']) {
                if ($bookRequest->cover_image_path) {
                    $data['cover_image_path'] = $this->updateImage(
                        file: $data['cover_image_path'],
                        directory: 'book-requests',
                        width: 100,
                        height: 150,
                        model: $bookRequest,
                        field: 'cover_image_path'
                    );
                } else {
                    $data['cover_image_path'] = $this->uploadImage(
                        file: $data['cover_image_path'],
                        directory: 'book-requests',
                        width: 100,
                        height: 150
                    );
                }
            }

            $bookRequest->update($data);

            return $bookRequest->load(['bookCategory']);
        });
    }

    /**
     * Delete a book request (Soft Delete).
     *
     * @param int $id Book request ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When book request is not found
     * @throws Exception When deletion fails
     */
    public function deleteBookRequest(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $bookRequest = BookRequest::query()->findOrFail($id);

            $bookRequest->delete();

            return true;
        });
    }

    /**
     * Force delete a book request (Permanent Delete).
     *
     * @param int $id Book request ID to permanently delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When book request is not found
     * @throws Exception When deletion fails
     */
    public function forceDeleteBookRequest(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $bookRequest = BookRequest::query()->findOrFail($id);

            $bookRequest->forceDelete();

            return true;
        });
    }

    /**
     * Bulk update book request status.
     *
     * @param array $ids Array of book request IDs to update
     * @param string $status New status (pending/in_progress/approved/rejected)
     * @return int Number of book requests updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateBookRequestStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return BookRequest::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete book requests (Soft Delete).
     *
     * @param array $ids Array of book request IDs to delete
     * @return int Number of book requests successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteBookRequests(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $bookRequests = BookRequest::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($bookRequests as $bookRequest) {
                $bookRequest->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Bulk force delete book requests (Permanent Delete).
     *
     * @param array $ids Array of book request IDs to permanently delete
     * @return int Number of book requests successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkForceDeleteBookRequests(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $bookRequests = BookRequest::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($bookRequests as $bookRequest) {
                $bookRequest->forceDelete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Book Category Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle all book category-related operations including CRUD
    | operations for book categories and category filtering. Book category
    | management includes creating, updating, deleting, and retrieving category
    | information with support for book count tracking and comprehensive filtering.
    |
    */

    /**
     * Get a paginated list of book categories with optional filtering and searching.
     *
     * @param int $perPage Number of items per page
     * @param string|null $search Search term for category name or description
     * @param string|null $status Filter by category status (active/inactive)
     * @return LengthAwarePaginator Paginated list of book categories with book counts
     */
    public function getBookCategories(int $perPage, ?string $search = null, ?string $status = null): LengthAwarePaginator
    {
        $query = BookCategory::query()->withCount('books')
            ->when($status, fn ($q) => $q->filterByStatus($status))
            ->when($search, fn ($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book category by ID.
     *
     * @param int $id Book category ID
     * @return BookCategory Book category model instance with book count
     * @throws ModelNotFoundException When book category is not found
     */
    public function getBookCategoryById(int $id): BookCategory
    {
        return BookCategory::query()->withCount('books')->findOrFail($id);
    }

    /**
     * Create a new book category.
     *
     * @param array $data Book category data including name, description, status, etc.
     * @return BookCategory Created book category instance
     * @throws Exception When creation fails
     */
    public function createBookCategory(array $data): BookCategory
    {
        return DB::transaction(function () use ($data) {
            return BookCategory::query()->create($data);
        });
    }

    /**
     * Update an existing book category.
     *
     * @param int $id Book category ID to update
     * @param array $data Updated book category data
     * @return BookCategory Updated book category instance
     * @throws ModelNotFoundException When book category is not found
     * @throws Exception When update fails
     */
    public function updateBookCategory(int $id, array $data): BookCategory
    {
        return DB::transaction(function () use ($data, $id) {
            $category = BookCategory::query()->findOrFail($id);

            $category->update($data);

            return $category;
        });
    }

    /**
     * Delete a book category (Soft Delete).
     *
     * @param int $id Book category ID to delete
     * @return bool True if deletion successful
     * @throws ModelNotFoundException When book category is not found
     * @throws Exception When category contains books
     */
    public function deleteBookCategory(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $category = BookCategory::query()->findOrFail($id);

            if ($category->books()->exists()) {
                throw new Exception('Cannot soft-delete a category that contains books. Please re-assign or delete all books first.');
            }

            $category->delete();

            return true;
        });
    }

    /**
     * Bulk update book category status.
     *
     * @param array $ids Array of book category IDs to update
     * @param string $status New status (active/inactive)
     * @return int Number of book categories updated
     * @throws Exception When bulk update fails
     */
    public function bulkUpdateBookCategoryStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return BookCategory::query()->whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete book categories (Soft Delete).
     *
     * @param array $ids Array of book category IDs to delete
     * @return int Number of book categories successfully deleted
     * @throws Exception When bulk deletion fails
     */
    public function bulkDeleteBookCategories(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $categories = BookCategory::query()->whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($categories as $category) {
                if ($category->books()->exists()) {
                    continue;
                }

                $category->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Book Issue/Return Methods
    |--------------------------------------------------------------------------
    |
    | These methods handle book issuing and returning operations, including
    | validation of member eligibility and due date management. Book circulation
    | management includes issuing books to members, processing returns, calculating
    | fines for overdue books, and tracking book availability with comprehensive
    | filtering and reporting capabilities.
    |
    */

    /**
     * Issue a book to a member.
     *
     * @param array $data Issue data including book_id, member_id, due_date
     * @return array Issue result with book and issue information
     * @throws Exception When book is not available or member already has the book
     */
    public function issueBook(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $book = Book::query()->findOrFail($data['book_id']);

            if ($book->quantity <= 0) {
                throw new Exception('Book is not available');
            }

            $existingIssue = IssueReturn::query()->where('book_id', $data['book_id'])
                ->where('member_id', $data['member_id'])
                ->where('status', IssueStatus::ISSUED->value)
                ->first();

            if ($existingIssue) {
                throw new Exception('Member already has this book');
            }

            $issue = IssueReturn::query()->create([
                'book_id' => $data['book_id'],
                'member_id' => $data['member_id'],
                'issue_date' => now(),
                'due_date' => $data['due_date'],
                'status' => IssueStatus::ISSUED->value,
            ]);

            $book->decrement('quantity');

            return [
                'issue' => $issue,
                'book' => $book->fresh(),
                'message' => 'Book issued successfully',
            ];
        });
    }

    /**
     * Return a book from a member.
     *
     * @param array $data Return data including book_id, member_id
     * @return array Return result with book, issue information, and fine amount
     * @throws Exception When book issue is not found
     */
    public function returnBook(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $issue = IssueReturn::query()->where('book_id', $data['book_id'])
                ->where('member_id', $data['member_id'])
                ->where('status', IssueStatus::ISSUED->value)
                ->firstOrFail();

            $fineAmount = 0;
            if ($issue->due_date < now()) {
                $daysOverdue = now()->diffInDays($issue->due_date);
                $fineAmount = $daysOverdue * 10;
            }

            $issue->update([
                'return_date' => now(),
                'fine_amount' => $fineAmount,
                'status' => IssueStatus::RETURNED->value,
            ]);

            $book = Book::query()->findOrFail($data['book_id']);
            $book->increment('quantity');

            return [
                'issue' => $issue,
                'book' => $book->fresh(),
                'fine_amount' => $fineAmount,
                'message' => 'Book returned successfully',
            ];
        });
    }

    /**
     * Get all book issues with filtering and pagination.
     *
     * @param int $perPage Number of items per page
     * @param string|null $status Filter by issue status (issued/returned)
     * @param int|null $memberId Filter by member ID
     * @param int|null $bookId Filter by book ID
     * @return LengthAwarePaginator Paginated list of book issues with relationships
     */
    public function getBookIssues(int $perPage, ?string $status = null, ?int $memberId = null, ?int $bookId = null): LengthAwarePaginator
    {
        $query = IssueReturn::with(['book', 'member'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($memberId, fn ($q) => $q->where('member_id', $memberId))
            ->when($bookId, fn ($q) => $q->where('book_id', $bookId));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | ID Card Settings Methods
    |--------------------------------------------------------------------------
    |

    | These methods handle all ID card setting-related operations including
    | CRUD operations for ID card settings and ID card setting filtering.

    */

    /**
     * Get ID card setting.
     *
     * @return IdCardSetting ID card setting model instance
     */
    public function getIdCardSetting(): IdCardSetting
    {
        return IdCardSetting::query()->where('slug', 'library-card')->first();
    }

    /**
     * Update or create an ID card setting.
     *
     * @param array $data ID card setting data including design, layout, etc.
     * @return IdCardSetting Updated or created ID card setting instance
     * @throws Exception When update or creation fails
     */
    public function updateOrCreateIdCardSetting(array $data): IdCardSetting
    {
        return DB::transaction(function () use ($data) {
            return IdCardSetting::query()->updateOrCreate(['id' => 1], $data);
        });
    }
}
