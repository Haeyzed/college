<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * Batch Request - Version 1
 *
 * This request class handles validation for creating and updating batches
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BatchRequest extends BaseRequest
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
        $batchId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The program ID that the batch belongs to.
             * @var int $program_id
             * @example 1
             */
            'program_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:programs,id'
            ],

            /**
             * The name of the batch.
             * @var string $name
             * @example "Batch 2024"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('batches', 'name')->ignore($batchId),
            ],

            /**
             * The unique code of the batch.
             * @var string $code
             * @example "B2024"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('batches', 'code')->ignore($batchId),
            ],

            /**
             * The academic year of the batch.
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
             * The start date of the batch.
             * @var string $start_date
             * @example "2024-01-01"
             */
            'start_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
                'after_or_equal:today'
            ],

            /**
             * The end date of the batch.
             * @var string $end_date
             * @example "2024-12-31"
             */
            'end_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
                'after:start_date'
            ],

            /**
             * The maximum number of students in the batch (optional).
             * @var int|null $max_students
             * @example 50
             */
            'max_students' => [
                'nullable',
                'integer',
                'min:1',
                'max:1000'
            ],

            /**
             * The description of the batch (optional).
             * @var string|null $description
             * @example "Computer Science batch for 2024"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The status of the batch (active/inactive).
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
            // Program ID
            'program_id.required' => 'The program is required.',
            'program_id.integer' => 'The program must be a valid integer.',
            'program_id.exists' => 'The selected program does not exist.',

            // Name
            'name.required' => 'The batch name is required.',
            'name.string' => 'The batch name must be a string.',
            'name.max' => 'The batch name cannot exceed 255 characters.',
            'name.unique' => 'This batch name is already registered.',

            // Code
            'code.required' => 'The batch code is required.',
            'code.string' => 'The batch code must be a string.',
            'code.max' => 'The batch code cannot exceed 50 characters.',
            'code.unique' => 'This batch code is already registered.',

            // Academic Year
            'academic_year.required' => 'The academic year is required.',
            'academic_year.integer' => 'The academic year must be a valid integer.',
            'academic_year.min' => 'The academic year must be at least 2020.',
            'academic_year.max' => 'The academic year cannot exceed 2030.',

            // Start Date
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date must be today or later.',

            // End Date
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',

            // Max Students
            'max_students.integer' => 'The maximum students must be a valid integer.',
            'max_students.min' => 'The maximum students must be at least 1.',
            'max_students.max' => 'The maximum students cannot exceed 1000.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid batch status.',

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
            'program_id' => 'program',
            'name' => 'batch name',
            'code' => 'batch code',
            'academic_year' => 'academic year',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'max_students' => 'maximum students',
            'description' => 'batch description',
            'status' => 'batch status',
            'sort_order' => 'sort order',
        ];
    }
}
