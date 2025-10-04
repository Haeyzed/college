<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\BookStatus;
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
             * The title of the book.
             * @var string $title
             * @example "Introduction to Programming"
             */
            'title' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                'unique:book_categories,title,'.$bookId
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
             * The ISBN of the book (optional).
             * @var string|null $isbn
             * @example "978-0-123456-78-9"
             */
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                $isUpdate ? Rule::unique('books', 'isbn')->ignore($bookId) : 'unique:books,isbn'
            ],

            /**
             * The category ID that the book belongs to.
             * @var int $category_id
             * @example 1
             */
            'category_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:book_categories,id'
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
             * The publication year of the book (optional).
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
             * The unique code of the book (optional).
             * @var string|null $code
             * @example "BK001"
             */
            'code' => [
                'nullable',
                'string',
                'max:255',
                $isUpdate ? Rule::unique('books', 'code')->ignore($bookId) : 'unique:books,code'
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
             * The description of the book (optional).
             * @var string|null $description
             * @example "A comprehensive guide to programming fundamentals"
             */
            'description' => [
                'nullable',
                'string'
            ],

            /**
             * The section where the book is located (optional).
             * @var string|null $section
             * @example "A1"
             */
            'section' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The column where the book is located (optional).
             * @var string|null $column
             * @example "Column 1"
             */
            'column' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The row where the book is located (optional).
             * @var string|null $row
             * @example "Row 1"
             */
            'row' => [
                'nullable',
                'string',
                'max:255'
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
             * The book image file (optional).
             * @var \Illuminate\Http\UploadedFile|null $image
             * @example "book_cover.jpg"
             */
            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif,svg,webp',
                'max:10240' // 10MB max
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
            'title.required' => 'Book title is required.',
            'title.string' => 'Book title must be a string.',
            'title.max' => 'Book title cannot exceed 255 characters.',
            'author.required' => 'Author name is required.',
            'author.string' => 'Author name must be a string.',
            'author.max' => 'Author name cannot exceed 255 characters.',
            'isbn.string' => 'ISBN must be a string.',
            'isbn.max' => 'ISBN cannot exceed 255 characters.',
            'isbn.unique' => 'This ISBN is already registered.',
            'category_id.required' => 'Book category is required.',
            'category_id.integer' => 'Book category must be a valid integer.',
            'category_id.exists' => 'Selected book category is invalid.',
            'publisher.string' => 'Publisher name must be a string.',
            'publisher.max' => 'Publisher name cannot exceed 255 characters.',
            'publish_year.integer' => 'Publication year must be a valid integer.',
            'publish_year.min' => 'Publication year must be after 1900.',
            'publish_year.max' => 'Publication year cannot be in the future.',
            'code.string' => 'Book code must be a string.',
            'code.max' => 'Book code cannot exceed 255 characters.',
            'code.unique' => 'This book code is already registered.',
            'language.string' => 'Language must be a string.',
            'language.max' => 'Language cannot exceed 255 characters.',
            'edition.string' => 'Edition must be a string.',
            'edition.max' => 'Edition cannot exceed 50 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be a valid integer.',
            'quantity.min' => 'Quantity must be at least 0.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be at least 0.',
            'description.string' => 'Description must be a string.',
            'section.string' => 'Section must be a string.',
            'section.max' => 'Section cannot exceed 255 characters.',
            'column.string' => 'Column must be a string.',
            'column.max' => 'Column cannot exceed 255 characters.',
            'row.string' => 'Row must be a string.',
            'row.max' => 'Row cannot exceed 255 characters.',
            'note.string' => 'Note must be a string.',
            'image.file' => 'Image must be a valid file.',
            'image.image' => 'Image must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'Image may not be greater than 10MB.',
            'status.string' => 'Status must be a valid string.',
            'status.enum' => 'Status must be a valid book status.',
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
            'publish_year' => 'publication year',
            'code' => 'book code',
            'language' => 'book language',
            'edition' => 'book edition',
            'quantity' => 'book quantity',
            'price' => 'book price',
            'description' => 'book description',
            'section' => 'book section',
            'column' => 'book column',
            'row' => 'book row',
            'note' => 'book note',
            'image' => 'book image',
            'status' => 'book status',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        if ($isUpdate) {
            $this->merge([
                'updated_by' => auth()->id() ?? 1,
            ]);
        } else {
            $this->merge([
                'created_by' => auth()->id() ?? 1,
                'status' => $this->status ?? BookStatus::ACTIVE->value, // Default to active
            ]);
        }
    }
}
