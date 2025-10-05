<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * Semester Request - Version 1
 *
 * This request class handles validation for creating and updating semesters
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SemesterRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $semesterId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The name of the semester.
             * @var string $name
             * @example "Fall 2024"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('semesters', 'name')->ignore($semesterId),
            ],

            /**
             * The unique code of the semester.
             * @var string $code
             * @example "F2024"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('semesters', 'code')->ignore($semesterId),
            ],

            /**
             * The academic year of the semester.
             * @var int $academic_year
             * @example 2024
             */
            'academic_year' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:2020',
                'max:2030'
            ],

            /**
             * The start date of the semester.
             * @var string $start_date
             * @example "2024-09-01"
             */
            'start_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date'
            ],

            /**
             * The end date of the semester.
             * @var string $end_date
             * @example "2024-12-31"
             */
            'end_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
                'after:start_date'
            ],

            /**
             * Whether this is the current semester.
             * @var bool|null $is_current
             * @example true
             */
            'is_current' => [
                'nullable',
                'boolean'
            ],

            /**
             * The description of the semester (optional).
             * @var string|null $description
             * @example "Fall semester for academic year 2024"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The status of the semester (active/inactive).
             * @var string $status
             * @example "active"
             */
            'status' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(Status::class)
            ],

            /**
             * The sort order for display (optional).
             * @var int|null $sort_order
             * @example 1
             */
            'sort_order' => [
                'nullable',
                'integer',
                'min:0'
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
            // Name
            'name.required' => 'The semester name is required.',
            'name.string' => 'The semester name must be a string.',
            'name.max' => 'The semester name cannot exceed 255 characters.',
            'name.unique' => 'This semester name is already registered.',

            // Code
            'code.required' => 'The semester code is required.',
            'code.string' => 'The semester code must be a string.',
            'code.max' => 'The semester code cannot exceed 50 characters.',
            'code.unique' => 'This semester code is already registered.',

            // Academic Year
            'academic_year.required' => 'The academic year is required.',
            'academic_year.integer' => 'The academic year must be a valid integer.',
            'academic_year.min' => 'The academic year must be at least 2020.',
            'academic_year.max' => 'The academic year cannot exceed 2030.',

            // Start Date
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',

            // End Date
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',

            // Is Current
            'is_current.boolean' => 'The current semester flag must be true or false.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid semester status.',

            // Sort Order
            'sort_order.integer' => 'The sort order must be a valid integer.',
            'sort_order.min' => 'The sort order must be at least 0.',
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
            'name' => 'semester name',
            'code' => 'semester code',
            'academic_year' => 'academic year',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'is_current' => 'current semester',
            'description' => 'semester description',
            'status' => 'semester status',
            'sort_order' => 'sort order',
        ];
    }
}
