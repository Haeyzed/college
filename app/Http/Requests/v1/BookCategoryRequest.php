<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\BookCategoryStatus;
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
            'title.required' => 'The category title is required.',
            'title.string' => 'The category title must be a string.',
            'title.max' => 'The category title cannot exceed 255 characters.',
            'title.unique' => 'A category with this title already exists.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',
            'status.required' => 'The category status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid book category status.',
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
            'title' => 'category title',
            'description' => 'category description',
            'status' => 'category status',
        ];
    }
}
