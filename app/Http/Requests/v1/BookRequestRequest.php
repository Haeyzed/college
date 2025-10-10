<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\BookRequestStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The category ID for the book request.
             * @var int $book_category_id
             * @example 1
             */
            'book_category_id' => [
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
             * The accession number of the book.
             * @var string|null $accession_number
             * @example "A00123"
             */
            'accession_number' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The author of the book.
             * @var string|null $author
             * @example "John Doe"
             */
            'author' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The publisher of the book.
             * @var string|null $publisher
             * @example "Prentice Hall"
             */
            'publisher' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The edition of the book.
             * @var string|null $edition
             * @example "3rd Edition"
             */
            'edition' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The publication year of the book.
             * @var int|null $publication_year
             * @example 2023
             */
            'publication_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y'))
            ],

            /**
             * The language of the book.
             * @var string|null $language
             * @example "English"
             */
            'language' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The estimated price of the book.
             * @var float|null $price
             * @example 50.99
             */
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99'
            ],

            /**
             * The quantity of copies requested.
             * @var int $quantity
             * @example 1
             */
            'quantity' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1'
            ],

            /**
             * The name of the person/department requesting the book.
             * @var string $requester_name
             * @example "Faculty of Science"
             */
            'requester_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The phone number of the requester.
             * @var string|null $requester_phone
             * @example "0123456789"
             */
            'requester_phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The email address of the requester.
             * @var string|null $requester_email
             * @example "request@college.edu"
             */
            'requester_email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * Detailed description/justification for the request.
             * @var string|null $description
             */
            'description' => [
                'nullable',
                'string',
            ],

            /**
             * Internal notes about the request.
             * @var string|null $note
             */
            'note' => [
                'nullable',
                'string',
            ],

            /**
             * An image of the book cover (optional).
             * @var UploadedFile|string|null $cover_image_path
             */
            'cover_image_path' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10240'
            ],

            /**
             * The status of the book request.
             * @var string $status
             * @example "pending"
             */
            'status' => [
                $isUpdate ? 'sometimes' : 'nullable',
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
            // Book Category
            'book_category_id.required' => 'The book category is required.',
            'book_category_id.integer' => 'The book category must be a valid integer ID.',
            'book_category_id.exists' => 'The selected book category is invalid or does not exist.',

            // Title
            'title.required' => 'The book title is required.',
            'title.string' => 'The book title must be a string.',
            'title.max' => 'The book title cannot exceed 255 characters.',

            // ISBN
            'isbn.string' => 'The ISBN must be a string.',
            'isbn.max' => 'The ISBN cannot exceed 30 characters.',

            // Accession Number
            'accession_number.string' => 'The accession number must be a string.',
            'accession_number.max' => 'The accession number cannot exceed 50 characters.',

            // Author
            'author.string' => 'The author name must be a string.',
            'author.max' => 'The author name cannot exceed 255 characters.',

            // Publisher
            'publisher.string' => 'The publisher name must be a string.',
            'publisher.max' => 'The publisher name cannot exceed 255 characters.',

            // Edition
            'edition.string' => 'The edition must be a string.',
            'edition.max' => 'The edition cannot exceed 50 characters.',

            // Publication Year
            'publication_year.integer' => 'The publication year must be a valid whole number.',
            'publication_year.min' => 'The publication year must be 1900 or later.',
            'publication_year.max' => 'The publication year cannot be later than the current year (' . date('Y') . ').',

            // Language
            'language.string' => 'The language must be a string.',
            'language.max' => 'The language cannot exceed 50 characters.',

            // Price
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be a non-negative value.',
            'price.max' => 'The price cannot exceed 999,999.99.',

            // Quantity
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity must be at least 1.',

            // Requester Details
            'requester_name.required' => 'The requester name is required.',
            'requester_name.string' => 'The requester name must be a string.',
            'requester_name.max' => 'The requester name cannot exceed 255 characters.',
            'requester_phone.string' => 'The requester phone number must be a string.',
            'requester_phone.max' => 'The requester phone number cannot exceed 20 characters.',
            'requester_email.email' => 'The requester email address must be a valid email format.',
            'requester_email.max' => 'The requester email address cannot exceed 255 characters.',

            // Description and Note
            'description.string' => 'The description must be a string.',
            'note.string' => 'The notes must be a string.',

            // Cover Image
            'cover_image_path.file' => 'The cover image file must be a valid file.',
            'cover_image_path.image' => 'The cover image file must be an image.',
            'cover_image_path.mimes' => 'The cover image must be one of the following types: :values.',
            'cover_image_path.max' => 'The cover image file size cannot exceed 10MB.',

            // Status
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid book request status.',
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
            'book_category_id' => 'book category',
            'title' => 'book title',
            'isbn' => 'ISBN',
            'accession_number' => 'accession number',
            'author' => 'author',
            'publisher' => 'publisher',
            'edition' => 'edition',
            'publication_year' => 'publication year',
            'language' => 'language',
            'price' => 'price',
            'quantity' => 'quantity',
            'requester_name' => 'requester name',
            'requester_phone' => 'requester phone number',
            'requester_email' => 'requester email address',
            'description' => 'description',
            'note' => 'notes',
            'cover_image_path' => 'cover image file',
            'status' => 'status',
        ];
    }
}
