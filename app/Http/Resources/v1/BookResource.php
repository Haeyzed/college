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
             * The ID of the category this book belongs to.
             * @var int $category_id
             * @example 1
             */
            'category_id' => $this->category_id,

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
             * The unique code of the book.
             * @var string|null $code
             * @example "BK001"
             */
            'code' => $this->code,

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
             * @var int|null $publish_year
             * @example 2023
             */
            'publish_year' => $this->publish_year,

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
             * The section where the book is located.
             * @var string|null $section
             * @example "A"
             */
            'section' => $this->section,

            /**
             * The column where the book is located.
             * @var string|null $column
             * @example "1"
             */
            'column' => $this->column,

            /**
             * The row where the book is located.
             * @var string|null $row
             * @example "1"
             */
            'row' => $this->row,

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
             * The book image path.
             * @var string|null $image
             * @example "books/book_cover.jpg"
             */
            'image' => $this->image,

            /**
             * The book image URL.
             * @var string|null $image_url
             * @example "http://localhost/storage/books/book_cover.jpg"
             */
            'image_url' => StorageHelper::getConfigurableStorageUrl($this->image, 'filesystems.default'),

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

            // Relationships
            /**
             * The category information (loaded when relationship is included).
             * @var BookCategoryResource|null $category
             */
            'category' => new BookCategoryResource($this->whenLoaded('category')),

            /**
             * The book issues/returns (loaded when relationship is included).
             * @var IssueReturnResource[]|null $issues
             */
            'issues' => \App\Http\Resources\v1\IssueReturnResource::collection($this->whenLoaded('issues')),

            // Computed fields
            /**
             * Whether the book is currently available for issue.
             * @var bool $is_available
             * @example true
             */
            'is_available' => $this->quantity > 0,

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

            /**
             * Whether the book has an image.
             * @var bool $has_image
             * @example true
             */
            'has_image' => !empty($this->image),

            /**
             * The book image information.
             * @var array $image_info
             * @example {"has_image": true, "url": "http://localhost/storage/books/book_cover.jpg"}
             */
            'image_info' => [
                'has_image' => !empty($this->image),
                'url' => StorageHelper::getConfigurableStorageUrl($this->image, 'filesystems.default'),
                'path' => $this->image,
            ],
        ];
    }
}
