<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\BookRequestStatus;
use Illuminate\Validation\Rule;

/**
 * BookRequest Request - Version 1
 *
 * This request class handles validation for creating and updating book requests
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookRequestRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $bookRequestId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The category ID for the book request.
             * @var int $category_id
             * @example 1
             */
            'category_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:book_categories,id'
            ],

            /**
             * The title of the book being requested.
             * @var string $title
             * @example "Introduction to Programming"
             */
            'title' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The ISBN of the book.
             * @var string|null $isbn
             * @example "978-0-123456-78-9"
             */
            'isbn' => [
                'nullable',
                'string',
                'max:30'
            ],

            /**
             * The unique code of the book.
             * @var string|null $code
             * @example "BK001"
             */
            'code' => [
                'nullable',
                'string',
                'max:191'
            ],

            /**
             * The author of the book.
             * @var string $author
             * @example "John Doe"
             */
            'author' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The publisher of the book.
             * @var string|null $publisher
             * @example "Tech Publications"
             */
            'publisher' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The edition of the book.
             * @var string|null $edition
             * @example "2nd Edition"
             */
            'edition' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The publication year of the book.
             * @var int|null $publish_year
             * @example 2023
             */
            'publish_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . date('Y')
            ],

            /**
             * The language of the book.
             * @var string|null $language
             * @example "English"
             */
            'language' => [
                'nullable',
                'string',
                'max:100'
            ],

            /**
             * The price of the book.
             * @var float|null $price
             * @example 29.99
             */
            'price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            /**
             * The requested quantity of the book.
             * @var int $quantity
             * @example 5
             */
            'quantity' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1'
            ],

            /**
             * The name of the person requesting the book.
             * @var string $request_by
             * @example "John Smith"
             */
            'request_by' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The phone number of the requester.
             * @var string|null $phone
             * @example "+1234567890"
             */
            'phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The email address of the requester.
             * @var string|null $email
             * @example "john@example.com"
             */
            'email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The description of the book request.
             * @var string|null $description
             * @example "A comprehensive guide to programming fundamentals"
             */
            'description' => [
                'nullable',
                'string'
            ],

            /**
             * Additional notes about the book request.
             * @var string|null $note
             * @example "Urgent request for next semester"
             */
            'note' => [
                'nullable',
                'string'
            ],

            /**
             * The book image file (optional).
             * @var \Illuminate\Http\UploadedFile|null $image
             * @example "book_cover.jpg"
             */
            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10240' // 10MB
            ],

            /**
             * The status of the book request.
             * @var string $status
             * @example "pending"
             */
            'status' => [
                'nullable',
                'string',
                Rule::enum(BookRequestStatus::class)
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Book category is required.',
            'category_id.exists' => 'Selected book category does not exist.',
            'title.required' => 'Book title is required.',
            'title.max' => 'Book title may not be greater than 255 characters.',
            'author.required' => 'Author name is required.',
            'author.max' => 'Author name may not be greater than 255 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least 1.',
            'request_by.required' => 'Requester name is required.',
            'request_by.max' => 'Requester name may not be greater than 255 characters.',
            'email.email' => 'Email must be a valid email address.',
            'publish_year.min' => 'Publication year must be at least 1900.',
            'publish_year.max' => 'Publication year cannot be in the future.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must be at least 0.',
            'image.file' => 'Image must be a valid file.',
            'image.image' => 'Image must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'Image may not be greater than 10MB.',
            'status.enum' => 'Status must be one of: pending, in_progress, approved, rejected.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'book category',
            'title' => 'book title',
            'isbn' => 'ISBN',
            'code' => 'book code',
            'author' => 'author',
            'publisher' => 'publisher',
            'edition' => 'edition',
            'publish_year' => 'publication year',
            'language' => 'language',
            'price' => 'price',
            'quantity' => 'quantity',
            'request_by' => 'requester name',
            'phone' => 'phone number',
            'email' => 'email address',
            'description' => 'description',
            'note' => 'notes',
            'image' => 'book image',
            'status' => 'status',
        ];
    }
}
