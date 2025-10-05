<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BookRequest;
use App\Http\Requests\v1\BookCategoryRequest;
use App\Http\Requests\v1\BookRequestRequest;
use App\Http\Requests\v1\IdCardSettingRequest;
use App\Http\Requests\v1\IssueBookRequest;
use App\Http\Requests\v1\ReturnBookRequest;
use App\Http\Resources\v1\BookResource;
use App\Http\Resources\v1\BookCategoryResource;
use App\Http\Resources\v1\BookRequestResource;
use App\Http\Resources\v1\IdCardSettingResource;
use App\Services\v1\LibraryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * LibraryController - Version 1
 *
 * Controller for managing library operations in the College Management System.
 * This controller handles books, book categories, and library-related API endpoints.
 *
 * @package App\Http\Controllers\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class LibraryController extends Controller
{
    /**
     * The library service instance.
     *
     * @var LibraryService
     */
    protected LibraryService $libraryService;

    /**
     * Create a new controller instance.
     *
     * @param LibraryService $libraryService
     */
    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    /*
    |--------------------------------------------------------------------------
    | Book Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all books with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getBooks(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $bookCategoryId = $request->query('book_category_id');
            $status = $request->query('status');
            $author = $request->query('author');
            $search = $request->query('search');
            $available = $request->query('available');

            $result = $this->libraryService->getBooks($perPage, $bookCategoryId, $status, $author, $search, $available);

            return response()->paginated(
                BookResource::collection($result),
                'Books retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve books: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific book by ID.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookResource}
     */
    public function getBook(int $id): JsonResponse
    {
        try {
            $book = $this->libraryService->getBookById($id);

            return response()->success(
                new BookResource($book),
                'Book retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new book.
     *
     * @requestMediaType multipart/form-data
     * @param BookRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookResource}
     */
    public function createBook(BookRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file upload
            if ($request->hasFile('cover_image_path')) {
                $validatedData['cover_image_path'] = $request->file('cover_image_path');
            }

            $book = $this->libraryService->createBook($validatedData);

            return response()->success(
                new BookResource($book),
                'Book created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing book.
     *
     * @requestMediaType multipart/form-data
     * @param BookRequest $request
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookResource}
     */
    public function updateBook(BookRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('cover_image_path')) {
                $validatedData['cover_image_path'] = $request->file('cover_image_path');
            }

            $book = $this->libraryService->updateBook($id, $validatedData);

            return response()->success(
                new BookResource($book),
                'Book updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a book (Soft Delete).
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string}
     */
    public function deleteBook(int $id): JsonResponse
    {
        try {
            $this->libraryService->deleteBook($id);

            return response()->success(
                null,
                'Book soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update book status.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateBookStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:books,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->libraryService->bulkUpdateBookStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} books"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update book status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete books (Soft Delete).
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteBooks(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:books,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->libraryService->bulkDeleteBooks($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} books"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete books: ' . $e->getMessage()
            );
        }
    }

    /**
     * Import books from Excel file.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function importBooks(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
                'book_category_id' => 'required|integer|exists:book_categories,id'
            ]);

            $file = $request->file('file');
            $bookCategoryId = $request->input('book_category_id');

            $result = $this->libraryService->importBooks($file, $bookCategoryId);

            if ($result['success']) {
                return response()->success(
                    $result['data'],
                    $result['message']
                );
            } else {
                return response()->badRequest(
                    is_string($result['message']) ? $result['message'] : 'Import failed'
                );
            }
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to import books: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get book import template.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBookImportTemplate(): JsonResponse
    {
        try {
            $template = $this->libraryService->getBookImportTemplate();

            return response()->success(
                $template,
                'Book import template retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book import template: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Book Request Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get a paginated list of book requests.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function getBookRequests(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $search = $request->query('search');

            $bookRequests = $this->libraryService->getBookRequests($perPage, $status, $search);

            return response()->paginated(
                BookRequestResource::collection($bookRequests),
                'Book requests retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book requests: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific book request by ID.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookRequestResource}
     */
    public function getBookRequest(int $id): JsonResponse
    {
        try {
            $bookRequest = $this->libraryService->getBookRequestById($id);

            return response()->success(
                new BookRequestResource($bookRequest),
                'Book request retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book request not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book request: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new book request.
     *
     * @requestMediaType multipart/form-data
     * @param BookRequestRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookRequestResource}
     */
    public function createBookRequest(BookRequestRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file upload
            if ($request->hasFile('cover_image_path')) {
                $validatedData['cover_image_path'] = $request->file('cover_image_path');
            }

            $bookRequest = $this->libraryService->createBookRequest($validatedData);

            return response()->success(
                new BookRequestResource($bookRequest),
                'Book request created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create book request: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing book request.
     *
     * @requestMediaType multipart/form-data
     * @param BookRequestRequest $request
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookRequestResource}
     */
    public function updateBookRequest(BookRequestRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            // Handle file upload
            if ($request->hasFile('cover_image_path')) {
                $validatedData['cover_image_path'] = $request->file('cover_image_path');
            }

            $bookRequest = $this->libraryService->updateBookRequest($id, $validatedData);

            return response()->success(
                new BookRequestResource($bookRequest),
                'Book request updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book request not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update book request: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a book request.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string}
     */
    public function deleteBookRequest(int $id): JsonResponse
    {
        try {
            $this->libraryService->deleteBookRequest($id);

            return response()->success(
                null,
                'Book request deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book request not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to delete book request: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update book request status.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateBookRequestStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:book_requests,id',
                'status' => 'required|string|in:pending,in_progress,approved,rejected'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->libraryService->bulkUpdateBookRequestStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} book requests"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update book request status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete book requests.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteBookRequests(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:book_requests,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->libraryService->bulkDeleteBookRequests($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully deleted {$deletedCount} book requests"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk delete book requests: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Book Category Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all book categories with filtering, searching, and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookCategoryResource[], meta: array{current_page: int, last_page: int, per_page: int, total: int, from: int|null, to: int|null}}
     */
    public function getBookCategories(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $search = $request->query('search');
            $status = $request->query('status');

            $result = $this->libraryService->getBookCategories($perPage, $search, $status);

            return response()->paginated(
                BookCategoryResource::collection($result),
                'Book categories retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book categories: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get a specific book category by ID.
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookCategoryResource}
     */
    public function getBookCategory(int $id): JsonResponse
    {
        try {
            $category = $this->libraryService->getBookCategoryById($id);

            return response()->success(
                new BookCategoryResource($category),
                'Book category retrieved successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book category not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book category: ' . $e->getMessage()
            );
        }
    }

    /**
     * Create a new book category.
     *
     * @param BookCategoryRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookCategoryResource}
     */
    public function createBookCategory(BookCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->libraryService->createBookCategory($request->validated());

            return response()->success(
                new BookCategoryResource($category),
                'Book category created successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to create book category: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update an existing book category.
     *
     * @param BookCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string, data: BookCategoryResource}
     */
    public function updateBookCategory(BookCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = $this->libraryService->updateBookCategory($id, $request->validated());

            return response()->success(
                new BookCategoryResource($category),
                'Book category updated successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book category not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update book category: ' . $e->getMessage()
            );
        }
    }

    /**
     * Delete a book category (Soft Delete).
     *
     * @param int $id
     * @return JsonResponse
     * @response array{success: bool, message: string}
     */
    public function deleteBookCategory(int $id): JsonResponse
    {
        try {
            $this->libraryService->deleteBookCategory($id);

            return response()->success(
                null,
                'Book category soft-deleted successfully'
            );
        } catch (ModelNotFoundException $e) {
            return response()->notFound('Book category not found');
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to soft-delete book category: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk update book category status.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkUpdateBookCategoryStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:book_categories,id',
                'status' => 'required|string|in:active,inactive'
            ]);

            $ids = $request->input('ids');
            $status = $request->input('status');
            $updatedCount = $this->libraryService->bulkUpdateBookCategoryStatus($ids, $status);

            return response()->success(
                ['updated_count' => $updatedCount],
                "Successfully updated {$updatedCount} book categories"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk update book category status: ' . $e->getMessage()
            );
        }
    }

    /**
     * Bulk delete book categories (Soft Delete).
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function bulkDeleteBookCategories(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:book_categories,id',
            ]);

            $ids = $request->input('ids');
            $deletedCount = $this->libraryService->bulkDeleteBookCategories($ids);

            return response()->success(
                ['deleted_count' => $deletedCount],
                "Successfully soft-deleted {$deletedCount} book categories"
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to bulk soft-delete book categories: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Book Issue/Return Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Issue a book to a member.
     *
     * @param IssueBookRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function issueBook(IssueBookRequest $request): JsonResponse
    {
        try {
            $result = $this->libraryService->issueBook($request->validated());

            return response()->success(
                $result,
                'Book issued successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to issue book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Return a book from a member.
     *
     * @param ReturnBookRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array}
     */
    public function returnBook(ReturnBookRequest $request): JsonResponse
    {
        try {
            $result = $this->libraryService->returnBook($request->validated());

            return response()->success(
                $result,
                'Book returned successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to return book: ' . $e->getMessage()
            );
        }
    }

    /**
     * Get all book issues with filtering and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: array{data: array[], links: array, meta: array}}
     */
    public function getBookIssues(Request $request): JsonResponse
    {
        try {
            $perPage = $request->query('per_page', config('app.pagination.per_page', 15));
            $status = $request->query('status');
            $memberId = $request->query('member_id');
            $bookId = $request->query('book_id');

            $result = $this->libraryService->getBookIssues($perPage, $status, $memberId, $bookId);

            return response()->paginated(
                $result,
                'Book issues retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve book issues: ' . $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ID Card Settings Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get ID card settings.
     *
     * @return JsonResponse
     * @response array{success: bool, message: string, data: IdCardSettingResource}
     */
    public function getIdCardSetting(): JsonResponse
    {
        try {
            $setting = $this->libraryService->getIdCardSetting();

            return response()->success(
                new IdCardSettingResource($setting),
                'ID card settings retrieved successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to retrieve ID card settings: ' . $e->getMessage()
            );
        }
    }

    /**
     * Update or create ID card settings.
     *
     * @param IdCardSettingRequest $request
     * @return JsonResponse
     * @response array{success: bool, message: string, data: IdCardSettingResource}
     */
    public function updateIdCardSetting(IdCardSettingRequest $request): JsonResponse
    {
        try {
            $setting = $this->libraryService->updateOrCreateIdCardSetting($request->validated());

            return response()->success(
                new IdCardSettingResource($setting),
                'ID card settings updated successfully'
            );
        } catch (Exception $e) {
            return response()->internalServerError(
                'Failed to update ID card settings: ' . $e->getMessage()
            );
        }
    }
}
