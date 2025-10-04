<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * IssueReturn Resource - Version 1
 *
 * This resource handles the transformation of IssueReturn model data
 * for API responses in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class IssueReturnResource extends JsonResource
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
             * The unique identifier of the issue return.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The book ID associated with this issue return.
             * @var int $book_id
             * @example 1
             */
            'book_id' => $this->book_id,

            /**
             * The member ID who issued/returned the book.
             * @var int $member_id
             * @example 1
             */
            'member_id' => $this->member_id,

            /**
             * The type of member (student, teacher, etc.).
             * @var string $member_type
             * @example "student"
             */
            'member_type' => $this->member_type,

            /**
             * The date when the book was issued.
             * @var string $issue_date
             * @example "2024-01-15T10:30:00.000000Z"
             */
            'issue_date' => $this->issue_date,

            /**
             * The due date for returning the book.
             * @var string $due_date
             * @example "2024-01-22T10:30:00.000000Z"
             */
            'due_date' => $this->due_date,

            /**
             * The date when the book was returned (null if not returned).
             * @var string|null $return_date
             * @example "2024-01-20T14:30:00.000000Z"
             */
            'return_date' => $this->return_date,

            /**
             * The fine amount for overdue return (null if no fine).
             * @var float|null $fine_amount
             * @example 50.00
             */
            'fine_amount' => $this->fine_amount,

            /**
             * The current status of the issue return.
             * @var string $status
             * @example "issued"
             */
            'status' => $this->status,

            /**
             * Additional notes for this issue return.
             * @var string|null $note
             * @example "Book in good condition"
             */
            'note' => $this->note,

            /**
             * The book details (loaded when relationship is included).
             * @var array|null $book
             */
            'book' => $this->whenLoaded('book', function () {
                return [
                    'id' => $this->book->id,
                    'title' => $this->book->title,
                    'isbn' => $this->book->isbn,
                    'author' => $this->book->author,
                    'status' => $this->book->status,
                ];
            }),

            /**
             * The member details (loaded when relationship is included).
             * @var mixed|null $member
             */
            'member' => $this->whenLoaded('member'),

            /**
             * Whether the book is currently overdue.
             * @var bool $is_overdue
             * @example false
             */
            'is_overdue' => $this->due_date < now() && $this->status === 'issued',

            /**
             * The number of days overdue (0 if not overdue).
             * @var int $days_overdue
             * @example 0
             */
            'days_overdue' => $this->due_date < now() && $this->status === 'issued' 
                ? now()->diffInDays($this->due_date) 
                : 0,

            /**
             * The creation timestamp.
             * @var string $created_at
             * @example "2024-01-15T10:30:00.000000Z"
             */
            'created_at' => $this->created_at,

            /**
             * The last update timestamp.
             * @var string $updated_at
             * @example "2024-01-15T10:30:00.000000Z"
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
