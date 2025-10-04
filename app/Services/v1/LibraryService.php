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
use Illuminate\Http\Request;
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
    | for books, book search, and book filtering by category.
    |
    */

    /**
     * Get a paginated list of books.
     */
    public function getBooks(int $perPage, ?int $categoryId = null, ?string $status = null, ?string $author = null, ?string $search = null, ?bool $available = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Book::with(['category', 'issues'])
            ->when($categoryId, fn ($q) => $q->filterByCategory($categoryId))
            ->when($status, fn ($q) => $q->filterByStatus($status))
            ->when($author, fn ($q) => $q->filterByAuthor($author))
            ->when($search, fn ($q) => $q->search($search))
            ->when($available, fn ($q) => $q->where('quantity', '>', 0));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book by ID.
     */
    public function getBookById(int $id): Book
    {
        return Book::with(['category', 'issues.member'])->findOrFail($id);
    }

    /**
     * Create a new book.
     */
    public function createBook(array $data): Book
    {
        return DB::transaction(function () use ($data) {
            // Handle image upload if provided
            if (isset($data['image']) && $data['image']) {
                $data['image'] = $this->uploadImage(
                    file: $data['image'],
                    directory: 'books',
                    disk: 'public',
                    width: 100,
                    height: 150,
                    maintainAspectRatio: true,
                    fit: 'contain'
                );
            }

            $book = Book::create($data);

            return $book->load(['category']);
        });
    }

    /**
     * Update a book.
     */
    public function updateBook(int $id, array $data): Book
    {
        return DB::transaction(function () use ($data, $id) {
            $book = Book::findOrFail($id);

            // Handle image upload/update if provided
            if (isset($data['image']) && $data['image']) {
                if ($book->image) {
                    // Update existing image
                    $data['image'] = $this->updateImage(
                        file: $data['image'],
                        directory: 'books',
                        disk: 'public',
                        width: 100,
                        height: 150,
                        maintainAspectRatio: true,
                        fit: 'contain',
                        model: $book,
                        field: 'image'
                    );
                } else {
                    // Upload new image
                    $data['image'] = $this->uploadImage(
                        file: $data['image'],
                        directory: 'books',
                        disk: 'public',
                        width: 100,
                        height: 150,
                        maintainAspectRatio: true,
                        fit: 'contain'
                    );
                }
            }

            $book->update($data);

            return $book->load(['category']);
        });
    }

    /**
     * Delete a book.
     */
    public function deleteBook(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $book = Book::findOrFail($id);

            // Check if book has any active issues
            $activeIssues = IssueReturn::where('book_id', $id)
                ->where('status', IssueStatus::ISSUED->value)
                ->count();

            if ($activeIssues > 0) {
                throw new Exception('Cannot delete book with active issues');
            }

            // Delete associated image if exists
            if ($book->image) {
                $this->deleteImage($book->image, 'books', 'public');
            }

            $book->delete();

            return true;
        });
    }

    /**
     * Bulk update book status.
     */
    public function bulkUpdateBookStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return Book::whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete books.
     */
    public function bulkDeleteBooks(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $books = Book::whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($books as $book) {
                // Check if book has any active issues
                $activeIssues = IssueReturn::where('book_id', $book->id)
                    ->where('status', IssueStatus::ISSUED->value)
                    ->count();

                if ($activeIssues > 0) {
                    continue; // Skip books with active issues
                }

                // Delete associated image if exists
                if ($book->image) {
                    $this->deleteImage($book->image, 'books', 'public');
                }

                $book->delete();
                $deletedCount++;
            }

            return $deletedCount;
        });
    }

    /**
     * Import books from Excel file.
     */
    public function importBooks(\Illuminate\Http\UploadedFile $file, int $categoryId): array
    {
        try {
            $data = ['category' => $categoryId];
            $import = new BookImport($data);
            Excel::import($import, $file);

            return [
                'success' => true,
                'message' => 'Books imported successfully',
                'data' => [
                    'imported_count' => $import->getRowCount() ?? 0,
                ],
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return [
                'success' => false,
                'message' => 'Validation failed: '.implode(', ', $e->errors()),
                'errors' => $e->errors(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Import failed: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Get import template for books.
     */
    public function getBookImportTemplate(): array
    {
        return [
            'headers' => ['title', 'isbn', 'author', 'publisher', 'edition', 'publish_year', 'language', 'price', 'quantity', 'code', 'section', 'column', 'row', 'description', 'note'],
            'sample_data' => [
                ['Introduction to Programming', '978-0-123456-78-9', 'John Doe', 'Tech Publications', '2nd Edition', 2023, 'English', 29.99, 10, 'BK001', 'A1', 'Column 1', 'Row 1', 'A comprehensive guide', 'Special edition'],
                ['Advanced Algorithms', '978-0-987654-32-1', 'Jane Smith', 'Academic Press', '1st Edition', 2022, 'English', 49.99, 5, 'BK002', 'A2', 'Column 2', 'Row 1', 'Advanced programming concepts', null],
            ],
            'required_fields' => ['title', 'isbn', 'author', 'quantity'],
            'optional_fields' => ['publisher', 'edition', 'publish_year', 'language', 'price', 'code', 'section', 'column', 'row', 'description', 'note'],
            'instructions' => [
                'title' => 'Book title (required)',
                'isbn' => 'ISBN number (required, must be unique)',
                'author' => 'Author name (required)',
                'publisher' => 'Publisher name (optional)',
                'edition' => 'Book edition (optional)',
                'publish_year' => 'Publication year (optional)',
                'language' => 'Book language (optional)',
                'price' => 'Book price (optional, numeric)',
                'quantity' => 'Available quantity (required, numeric)',
                'code' => 'Book code (optional)',
                'section' => 'Library section (optional)',
                'column' => 'Library column (optional)',
                'row' => 'Library row (optional)',
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
    | operations for book requests and request filtering.
    |
    */

    /**
     * Get a paginated list of book requests.
     */
    public function getBookRequests(int $perPage, ?string $status = null, ?string $search = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = BookRequest::with(['category'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search, fn ($q) => $q->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('request_by', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book request by ID.
     */
    public function getBookRequestById(int $id): BookRequest
    {
        return BookRequest::with(['category'])->findOrFail($id);
    }

    /**
     * Create a new book request.
     */
    public function createBookRequest(array $data): BookRequest
    {
        return DB::transaction(function () use ($data) {
            // Handle image upload if provided
            if (isset($data['image']) && $data['image']) {
                $data['image'] = $this->uploadImage(
                    file: $data['image'],
                    directory: 'book-requests',
                    disk: 'public',
                    width: 100,
                    height: 150,
                    maintainAspectRatio: true,
                    fit: 'contain'
                );
            }

            $bookRequest = BookRequest::create($data);

            return $bookRequest->load(['category']);
        });
    }

    /**
     * Update a book request.
     */
    public function updateBookRequest(int $id, array $data): BookRequest
    {
        return DB::transaction(function () use ($data, $id) {
            $bookRequest = BookRequest::findOrFail($id);

            // Handle image upload/update if provided
            if (isset($data['image']) && $data['image']) {
                if ($bookRequest->image) {
                    // Update existing image
                    $data['image'] = $this->updateImage(
                        file: $data['image'],
                        directory: 'book-requests',
                        disk: 'public',
                        width: 100,
                        height: 150,
                        maintainAspectRatio: true,
                        fit: 'contain',
                        model: $bookRequest,
                        field: 'image'
                    );
                } else {
                    // Upload new image
                    $data['image'] = $this->uploadImage(
                        file: $data['image'],
                        directory: 'book-requests',
                        disk: 'public',
                        width: 100,
                        height: 150,
                        maintainAspectRatio: true,
                        fit: 'contain'
                    );
                }
            }

            $bookRequest->update($data);

            return $bookRequest->load(['category']);
        });
    }

    /**
     * Delete a book request.
     */
    public function deleteBookRequest(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $bookRequest = BookRequest::findOrFail($id);

            // Delete associated image if exists
            if ($bookRequest->image) {
                $this->deleteImage($bookRequest->image, 'book-requests', 'public');
            }

            $bookRequest->delete();

            return true;
        });
    }

    /**
     * Bulk update book request status.
     */
    public function bulkUpdateBookRequestStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return BookRequest::whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete book requests.
     */
    public function bulkDeleteBookRequests(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $bookRequests = BookRequest::whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($bookRequests as $bookRequest) {
                // Delete associated image if exists
                if ($bookRequest->image) {
                    $this->deleteImage($bookRequest->image, 'book-requests', 'public');
                }

                $bookRequest->delete();
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
    | operations for book categories and category statistics.
    |
    */

    /**
     * Get a paginated list of book categories.
     */
    public function getBookCategories(int $perPage, ?string $status = null, ?string $search = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = BookCategory::withCount('books')
            ->when($status, fn ($q) => $q->filterByStatus($status))
            ->when($search, fn ($q) => $q->search($search));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get a specific book category by ID.
     */
    public function getBookCategoryById(int $id): BookCategory
    {
        return BookCategory::withCount('books')->findOrFail($id);
    }

    /**
     * Create a new book category.
     */
    public function createBookCategory(array $data): BookCategory
    {
        return DB::transaction(function () use ($data) {
            $category = BookCategory::create($data);

            return $category;
        });
    }

    /**
     * Update a book category.
     */
    public function updateBookCategory(int $id, array $data): BookCategory
    {
        return DB::transaction(function () use ($data, $id) {
            $category = BookCategory::findOrFail($id);
            $category->update($data);

            return $category;
        });
    }

    /**
     * Delete a book category.
     */
    public function deleteBookCategory(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $category = BookCategory::findOrFail($id);

            // Check if category has books
            if ($category->books()->count() > 0) {
                throw new Exception('Cannot delete category with existing books');
            }

            $category->delete();

            return true;
        });
    }

    /**
     * Bulk update book category status.
     */
    public function bulkUpdateBookCategoryStatus(array $ids, string $status): int
    {
        return DB::transaction(function () use ($ids, $status) {
            return BookCategory::whereIn('id', $ids)->update(['status' => $status]);
        });
    }

    /**
     * Bulk delete book categories.
     */
    public function bulkDeleteBookCategories(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $categories = BookCategory::whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($categories as $category) {
                // Check if category has books
                if ($category->books()->count() > 0) {
                    continue; // Skip categories with books
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
    | validation of member eligibility and due date management.
    |
    */

    /**
     * Issue a book to a member.
     */
    public function issueBook(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $book = Book::findOrFail($data['book_id']);

            // Check availability
            if ($book->quantity <= 0) {
                throw new Exception('Book is not available');
            }

            // Check if member already has this book
            $existingIssue = IssueReturn::where('book_id', $data['book_id'])
                ->where('member_id', $data['member_id'])
                ->where('status', IssueStatus::ISSUED->value)
                ->first();

            if ($existingIssue) {
                throw new Exception('Member already has this book');
            }

            // Create issue record
            $issue = IssueReturn::create([
                'book_id' => $data['book_id'],
                'member_id' => $data['member_id'],
                'issue_date' => now(),
                'due_date' => $data['due_date'],
                'status' => IssueStatus::ISSUED->value,
            ]);

            // Update book quantity
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
     */
    public function returnBook(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $issue = IssueReturn::where('book_id', $data['book_id'])
                ->where('member_id', $data['member_id'])
                ->where('status', IssueStatus::ISSUED->value)
                ->firstOrFail();

            // Calculate fine if overdue
            $fineAmount = 0;
            if ($issue->due_date < now()) {
                $daysOverdue = now()->diffInDays($issue->due_date);
                $fineAmount = $daysOverdue * 10; // 10 per day fine
            }

            $issue->update([
                'return_date' => now(),
                'fine_amount' => $fineAmount,
                'status' => IssueStatus::RETURNED->value,
            ]);

            // Update book quantity
            $book = Book::findOrFail($data['book_id']);
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
     */
    public function getBookIssues(int $perPage, ?string $status = null, ?int $memberId = null, ?int $bookId = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = IssueReturn::with(['book', 'member'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($memberId, fn ($q) => $q->where('member_id', $memberId))
            ->when($bookId, fn ($q) => $q->where('book_id', $bookId));

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get book availability.
     */
    public function getBookAvailability(int $bookId): array
    {
        $book = Book::findOrFail($bookId);

        $availableQuantity = $book->quantity;
        $issuedQuantity = IssueReturn::where('book_id', $bookId)
            ->where('status', IssueStatus::ISSUED->value)
            ->count();

        return [
            'book_id' => $bookId,
            'title' => $book->title,
            'total_quantity' => $book->quantity + $issuedQuantity,
            'available_quantity' => $availableQuantity,
            'issued_quantity' => $issuedQuantity,
            'is_available' => $availableQuantity > 0,
        ];
    }

    /**
     * Get book category statistics.
     */
    public function getBookCategoryStatistics(): array
    {
        $total = BookCategory::count();
        $active = BookCategory::filterByStatus(BookCategoryStatus::ACTIVE->value)->count();
        $inactive = BookCategory::filterByStatus(BookCategoryStatus::INACTIVE->value)->count();

        $categoriesWithBooks = BookCategory::has('books')->count();
        $categoriesWithoutBooks = BookCategory::doesntHave('books')->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'with_books' => $categoriesWithBooks,
            'without_books' => $categoriesWithoutBooks,
            'active_rate' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
        ];
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
     */
    public function getIdCardSetting(): IdCardSetting
    {
        return IdCardSetting::first();
    }

    /**
     * Update or create an ID card setting.
     */
    public function updateOrCreateIdCardSetting(array $data): IdCardSetting
    {
        return DB::transaction(function () use ($data) {
            return IdCardSetting::updateOrCreate(['id' => 1], $data);
        });
    }
}
