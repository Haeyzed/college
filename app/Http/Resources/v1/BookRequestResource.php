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
             * The accession number of the book.
             * @var string|null $accession_number
             * @example "A00123"
             */
            'accession_number' => $this->accession_number,

            /**
             * The author of the book.
             * @var string|null $author
             * @example "John Doe"
             */
            'author' => $this->author,

            /**
             * The publisher of the book.
             * @var string|null $publisher
             * @example "Prentice Hall"
             */
            'publisher' => $this->publisher,

            /**
             * The edition of the book.
             * @var string|null $edition
             * @example "3rd Edition"
             */
            'edition' => $this->edition,

            /**
             * The publication year of the book.
             * @var int|null $publication_year
             * @example 2023
             */
            'publication_year' => (int) $this->publication_year,

            /**
             * The language of the book.
             * @var string|null $language
             * @example "English"
             */
            'language' => $this->language,

            /**
             * The estimated price of the book.
             * @var float|null $price
             * @example 50.99
             */
            'price' => (float) $this->price,

            /**
             * The quantity of copies requested.
             * @var int $quantity
             * @example 1
             */
            'quantity' => (int) $this->quantity,

            /**
             * The name of the person/department requesting the book.
             * @var string $requester_name
             * @example "Faculty of Science"
             */
            'requester_name' => $this->requester_name,

            /**
             * The phone number of the requester.
             * @var string|null $requester_phone
             * @example "0123456789"
             */
            'requester_phone' => $this->requester_phone,

            /**
             * The email address of the requester.
             * @var string|null $requester_email
             * @example "request@college.edu"
             */
            'requester_email' => $this->requester_email,

            /**
             * Detailed description/justification for the request.
             * @var string|null $description
             */
            'description' => $this->description,

            /**
             * Internal notes about the request.
             * @var string|null $note
             */
            'note' => $this->note,

            /**
             * The book cover image path.
             * @var string|null $cover_image_path
             * @example "book-requests/book_cover.jpg"
             */
            'cover_image_path' => $this->cover_image_path,

            /**
             * The book cover image URL.
             * @var string|null $cover_image_url
             * @example "http://localhost/storage/book-requests/book_cover.jpg"
             */
            'cover_image_url' => StorageHelper::getConfigurableStorageUrl($this->cover_image_path, 'filesystems.default'),

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

            /**
             * The soft delete timestamp.
             * @var string|null $deleted_at
             * @example "2024-01-10 10:00:00"
             */
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),

            /**
             * The category information (loaded when relationship is included).
             * @var BookCategoryResource|null $book_category
             */
            'book_category' => BookCategoryResource::make($this->whenLoaded('bookCategory')),
        ];
    }
}
