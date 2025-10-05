<?php

namespace App\Http\Resources\v1;

use App\Enums\v1\IssueStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\StorageHelper;

/**
 * BookResource - Version 1
 *
 * Resource for transforming Book model data into API responses.
 * This resource handles book data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * The unique identifier of the book.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The title of the book.
             * @var string $title
             * @example "Introduction to Programming"
             */
            'title' => $this->title,

            /**
             * The ISBN of the book.
             * @var string|null $isbn
             * @example "978-0-123456-78-9"
             */
            'isbn' => $this->isbn,

            /**
             * The unique internal accession number for the book.
             * @var string|null $accession_number
             * @example "LMS-90021"
             */
            'accession_number' => $this->accession_number,

            /**
             * The author of the book.
             * @var string $author
             * @example "John Doe"
             */
            'author' => $this->author,

            /**
             * The publisher of the book.
             * @var string|null $publisher
             * @example "Tech Publications"
             */
            'publisher' => $this->publisher,

            /**
             * The edition of the book.
             * @var string|null $edition
             * @example "2nd Edition"
             */
            'edition' => $this->edition,

            /**
             * The publication year of the book.
             * @var int|null $publication_year
             * @example 2023
             */
            'publication_year' => $this->publication_year,

            /**
             * The language of the book.
             * @var string|null $language
             * @example "English"
             */
            'language' => $this->language,

            /**
             * The price of the book.
             * @var float|null $price
             * @example 29.99
             */
            'price' => $this->price,

            /**
             * The available quantity of the book.
             * @var int $quantity
             * @example 10
             */
            'quantity' => $this->quantity,

            /**
             * The shelf location (main section) where the book is stored.
             * @var string|null $shelf_location
             * @example "Science-A"
             */
            'shelf_location' => $this->shelf_location,

            /**
             * The shelf column where the book is stored.
             * @var string|null $shelf_column
             * @example "C-2"
             */
            'shelf_column' => $this->shelf_column,

            /**
             * The shelf row where the book is stored.
             * @var string|null $shelf_row
             * @example "R-5"
             */
            'shelf_row' => $this->shelf_row,

            /**
             * The description of the book.
             * @var string|null $description
             * @example "A comprehensive guide to programming fundamentals"
             */
            'description' => $this->description,

            /**
             * Additional notes about the book.
             * @var string|null $note
             * @example "Reference book"
             */
            'note' => $this->note,

            /**
             * The path to the book's cover image.
             * @var string|null $cover_image_path
             * @example "books/book_cover.jpg"
             */
            'cover_image_path' => $this->cover_image_path,

            /**
             * The book image URL.
             * @var string|null $image_url
             * @example "http://localhost/storage/books/book_cover.jpg"
             */
            'cover_image_url' => StorageHelper::getConfigurableStorageUrl($this->cover_image, 'filesystems.default'),

            /**
             * Whether the book has a cover image path.
             * @var bool $has_image
             * @example true
             */
            'has_cover_image' => !empty($this->cover_image_path),

            /**
             * The status of the book (0=Inactive, 1=Active).
             * @var int $status
             * @example 1
             */
            'status' => $this->status,

            /**
             * The creation timestamp.
             * @var string|null $created_at
             * @example "2023-12-01 10:30:00"
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            /**
             * The last update timestamp.
             * @var string|null $updated_at
             * @example "2023-12-01 15:45:00"
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            /**
             * Timestamp when the record was soft deleted. Null if not deleted.
             * @var string|null $deleted_at
             * @example "2024-05-15T10:00:00.000000Z"
             */
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),

            /**
             * The book category information (loaded when relationship is included).
             * @var BookCategoryResource|null $category
             */
            'book_category' => new BookCategoryResource($this->whenLoaded('bookCategory')),

            /**
             * The book issues/returns (loaded when relationship is included).
             * @var IssueReturnResource[]|null $issues
             */
            'issues' => IssueReturnResource::collection($this->whenLoaded('issues')),

            /**
             * Whether the book is currently available (quantity > 0 and not soft deleted).
             * @var bool $is_available
             * @example true
             */
            'is_available' => $this->quantity > 0 && is_null($this->deleted_at),

            /**
             * The number of currently issued copies (computed when issues are loaded).
             * @var int|null $issued_count
             * @example 3
             */
            'issued_count' => $this->whenLoaded('issues', function () {
                return $this->issues->where('status', IssueStatus::ISSUED->value)->count();
            }),

            /**
             * The number of overdue copies (computed when issues are loaded).
             * @var int|null $overdue_count
             * @example 1
             */
            'overdue_count' => $this->whenLoaded('issues', function () {
                return $this->issues->where('status', IssueStatus::ISSUED->value)
                    ->where('due_date', '<', now())
                    ->count();
            }),
        ];
    }
}
