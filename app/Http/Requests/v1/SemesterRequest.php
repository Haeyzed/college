<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
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
             * The IDs of the programs associated with the semester.
             * @var array<int> $programs
             * @example [1, 5, 8]
             */
            'programs' => [
                $isUpdate ? 'sometimes' : 'required',
                'array',
                'min:1', // Ensures the array is not empty
            ],
            'programs.*' => [
                'required',
                'integer',
                // Validates that each ID exists in the 'programs' table
                Rule::exists('programs', 'id'),
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

            // Programs
            'programs.required' => 'At least one program ID is required for the semester.',
            'programs.array' => 'The programs field must be an array of program IDs.',
            'programs.min' => 'At least one program must be selected.',
            'programs.*.required' => 'Each program ID in the list is required.',
            'programs.*.integer' => 'Each program ID must be a valid integer.',
            'programs.*.exists' => 'One or more selected program IDs are invalid.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid semester status.',
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
            'academic_year' => 'academic year',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'is_current' => 'current semester',
            'programs' => 'programs',
            'programs.*' => 'program ID',
            'description' => 'semester description',
            'status' => 'semester status',
        ];
    }
}
