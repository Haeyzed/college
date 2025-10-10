<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\BookCategoryStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Book Category Request - Version 1
 *
 * This request class handles validation for creating and updating book categories
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BookCategoryRequest extends BaseRequest
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
        $categoryId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The title of the book category.
             * @var string $title
             * @example "Computer Science"
             */
            'title' => [
                'required',
                'string',
                'max:255',
                $isUpdate ? Rule::unique('book_categories', 'title')->ignore($categoryId) : 'unique:book_categories,title'
            ],

            /**
             * The internal short code for the category (optional).
             * @var string|null $code
             * @example "CS"
             */
            'code' => [
                'nullable',
                'string',
                'max:20',
                $isUpdate ? Rule::unique('book_categories', 'code')->ignore($categoryId) : 'unique:book_categories,code'
            ],

            /**
             * The description of the book category (optional).
             * @var string|null $description
             * @example "Books related to computer science and programming"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The status of the book category (active/inactive).
             * @var string $status
             * @example "active"
             */
            'status' => [
                'required',
                'string',
                Rule::enum(BookCategoryStatus::class)
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
            'title.required' => 'The book category title is required.',
            'title.string' => 'The book category title must be a string.',
            'title.max' => 'The book category title cannot exceed 255 characters.',
            'title.unique' => 'A book category with this title already exists.',

            // Code
            'code.string' => 'The book category code must be a string.',
            'code.max' => 'The book category code cannot exceed 20 characters.',
            'code.unique' => 'A book category with this code already exists.',

            // Description
            'description.string' => 'The book category description must be a string.',
            'description.max' => 'The book category description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The book category status is required.',
            'status.string' => 'The book category status must be a string.',
            'status.enum' => 'The book category status must be a valid book category status.',
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
            'title' => 'book category title',
            'code' => 'book category code',
            'description' => 'book category description',
            'status' => 'book category status',
        ];
    }
}
