<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BookCategoryResource - Version 2.0.0
 *
 * Resource for transforming book category data in the College Management System,
 * adapted for new fields and soft delete status.
 *
 * @package App\Http\Resources\v1
 * @version 2.0.0
 * @author Softmax Technologies
 */
class BookCategoryResource extends JsonResource
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
             * The unique identifier of the book category.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The title of the book category.
             * @var string $title
             * @example "Computer Science"
             */
            'title' => $this->title,

            /**
             * The URL-friendly slug for the category.
             * @var string $slug
             * @example "computer-science"
             */
            'slug' => $this->slug,

            /**
             * The internal short code for the category.
             * @var string|null $code
             * @example "CS"
             */
            'code' => $this->code,

            /**
             * The description of the book category.
             * @var string|null $description
             * @example "Books related to computer science and programming"
             */
            'description' => $this->description,

            /**
             * The status of the category (active/inactive).
             * @var string $status
             * @example "active"
             */
            'status' => $this->status,

            /**
             * The number of books in this category (computed when relationship is loaded).
             * @var int|null $books_count
             * @example 25
             */
            'books_count' => $this->when(isset($this->books_count), $this->books_count),

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
        ];
    }
}
