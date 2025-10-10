<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\BookStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Book Request - Version 1
 *
 * This request class handles validation for creating and updating books
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookRequest extends BaseRequest
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
        $bookId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The book category ID that the book belongs to.
             * @var int $book_category_id
             * @example 1
             */
            'book_category_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:book_categories,id'
            ],

            /**
             * The title of the book.
             * @var string $title
             * @example "Introduction to Programming"
             */
            'title' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
            ],

            /**
             * The ISBN of the book (optional).
             * @var string|null $isbn
             * @example "978-0-123456-78-9"
             */
            'isbn' => [
                'nullable',
                'string',
                'max:30',
                $isUpdate ? Rule::unique('books', 'isbn')->ignore($bookId) : 'unique:books,isbn'
            ],

            /**
             * The Accession Number (internal inventory code) of the book.
             * @var string|null $accession_number
             * @example "LMS-90021"
             */
            'accession_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:50',
                $isUpdate ? Rule::unique('books', 'accession_number')->ignore($bookId) : 'unique:books,accession_number'
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
             * The publisher of the book (optional).
             * @var string|null $publisher
             * @example "Tech Publications"
             */
            'publisher' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The edition of the book (optional).
             * @var string|null $edition
             * @example "2nd Edition"
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
                'sometimes',
                'nullable',
                'integer',
                'min:1000',
                'max:' . date('Y')
            ],

            /**
             * The language of the book (optional).
             * @var string|null $language
             * @example "English"
             */
            'language' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The price of the book (optional).
             * @var float|null $price
             * @example 29.99
             */
            'price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            /**
             * The quantity of books available.
             * @var int $quantity
             * @example 10
             */
            'quantity' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:0'
            ],

            /**
             * The shelf location (main section) where the book is stored.
             * @var string|null $shelf_location
             * @example "Science-A"
             */
            'shelf_location' => [
                'sometimes',
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The shelf column where the book is stored.
             * @var string|null $shelf_column
             * @example "C-2"
             */
            'shelf_column' => [
                'sometimes',
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The shelf row where the book is stored.
             * @var string|null $shelf_row
             * @example "R-5"
             */
            'shelf_row' => [
                'sometimes',
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The description of the book (optional).
             * @var string|null $description
             * @example "A comprehensive guide to programming fundamentals"
             */
            'description' => [
                'nullable',
                'string'
            ],

            /**
             * The note about the book (optional).
             * @var string|null $note
             * @example "Special edition book"
             */
            'note' => [
                'nullable',
                'string'
            ],

            /**
             * The book cover image file.
             * @var mixed|null $cover_image_path
             */
            'cover_image_path' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /**
             * The status of the book (active/inactive).
             * @var string|null $status
             * @example "active"
             */
            'status' => [
                'nullable',
                'string',
                Rule::enum(BookStatus::class)
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
            // Title
            'title.required' => 'The book title is required.',
            'title.string' => 'The book title must be a string.',
            'title.max' => 'The book title cannot exceed 255 characters.',

            // Author
            'author.required' => 'The author name is required.',
            'author.string' => 'The author name must be a string.',
            'author.max' => 'The author name cannot exceed 255 characters.',

            // ISBN
            'isbn.string' => 'The ISBN must be a string.',
            'isbn.max' => 'The ISBN cannot exceed 30 characters.',
            'isbn.unique' => 'This ISBN is already registered for another book.',

            // Category ID
            'category_id.required' => 'The book category is required.',
            'category_id.integer' => 'The book category must be a valid integer.',
            'category_id.exists' => 'The selected book category is invalid.',

            // Publisher
            'publisher.string' => 'The publisher name must be a string.',
            'publisher.max' => 'The publisher name cannot exceed 255 characters.',

            // Publication Year
            'publication_year.integer' => 'The publication year must be a valid integer.',
            'publication_year.min' => 'The publication year must be after 999.',
            'publication_year.max' => 'The publication year cannot be in the future.',

            // Accession Number
            'accession_number.string' => 'The accession number must be a string.',
            'accession_number.max' => 'The accession number cannot exceed 50 characters.',
            'accession_number.unique' => 'This accession number is already registered for another book.',

            // Language
            'language.string' => 'The language must be a string.',
            'language.max' => 'The language cannot exceed 255 characters.',

            // Edition
            'edition.string' => 'The edition must be a string.',
            'edition.max' => 'The edition cannot exceed 50 characters.',

            // Quantity
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be a valid integer.',
            'quantity.min' => 'The quantity must be at least 0.',

            // Price
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',

            // Description
            'description.string' => 'The description must be a string.',

            // Shelf Location
            'shelf_location.string' => 'The shelf location must be a string.',
            'shelf_location.max' => 'The shelf location cannot exceed 50 characters.',

            // Shelf Column
            'shelf_column.string' => 'The shelf column must be a string.',
            'shelf_column.max' => 'The shelf column cannot exceed 50 characters.',

            // Shelf Row
            'shelf_row.string' => 'The shelf row must be a string.',
            'shelf_row.max' => 'The shelf row cannot exceed 50 characters.',

            // Note
            'note.string' => 'The note must be a string.',

            // Cover Image Path
            'cover_image_path.file' => 'The cover image must be a valid file.',
            'cover_image_path.mimes' => 'The cover image must be a file of type: jpg, jpeg, png, webp.',
            'cover_image_path.max' => 'The cover image may not be greater than 2MB.',

            // Status
            'status.string' => 'The status must be a valid string.',
            'status.enum' => 'The status must be a valid book status.',
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
            'title' => 'book title',
            'author' => 'author name',
            'isbn' => 'ISBN',
            'category_id' => 'book category',
            'publisher' => 'publisher name',
            'publication_year' => 'publication year',
            'accession_number' => 'accession number',
            'language' => 'book language',
            'edition' => 'book edition',
            'quantity' => 'book quantity',
            'price' => 'book price',
            'description' => 'book description',
            'shelf_location' => 'shelf location',
            'shelf_column' => 'shelf column',
            'shelf_row' => 'shelf row',
            'note' => 'book note',
            'cover_image_path' => 'cover image',
            'status' => 'book status',
        ];
    }
}
