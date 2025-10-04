<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\StorageHelper;

/**
 * BookRequestResource - Version 1
 *
 * Resource for transforming BookRequest model data into API responses.
 * This resource handles book request data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookRequestResource extends JsonResource
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
             * The unique identifier of the book request.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The ID of the category this book request belongs to.
             * @var int $category_id
             * @example 1
             */
            'category_id' => $this->category_id,

            /**
             * The title of the book being requested.
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
             * The requested quantity of the book.
             * @var int $quantity
             * @example 5
             */
            'quantity' => $this->quantity,

            /**
             * The name of the person requesting the book.
             * @var string $request_by
             * @example "John Smith"
             */
            'request_by' => $this->request_by,

            /**
             * The phone number of the requester.
             * @var string|null $phone
             * @example "+1234567890"
             */
            'phone' => $this->phone,

            /**
             * The email address of the requester.
             * @var string|null $email
             * @example "john@example.com"
             */
            'email' => $this->email,

            /**
             * The description of the book request.
             * @var string|null $description
             * @example "A comprehensive guide to programming fundamentals"
             */
            'description' => $this->description,

            /**
             * Additional notes about the book request.
             * @var string|null $note
             * @example "Urgent request for next semester"
             */
            'note' => $this->note,

            /**
             * The book image path.
             * @var string|null $image
             * @example "book-requests/book_cover.jpg"
             */
            'image' => $this->image,

            /**
             * The book image URL.
             * @var string|null $image_url
             * @example "http://localhost/storage/book-requests/book_cover.jpg"
             */
            'image_url' => StorageHelper::getConfigurableStorageUrl($this->image, 'filesystems.default'),

            /**
             * The status of the book request.
             * @var string $status
             * @example "pending"
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
        ];
    }
}
