<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * Section Request - Version 1
 *
 * This request class handles validation for creating and updating sections
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SectionRequest extends BaseRequest
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
        $sectionId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The batch ID that the section belongs to.
             * @var int $batch_id
             * @example 1
             */
            'batch_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:batches,id'
            ],

            /**
             * The name of the section.
             * @var string $name
             * @example "Section A"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('sections', 'name')->where('batch_id', $this->input('batch_id'))->ignore($sectionId),
            ],

            /**
             * The unique code of the section.
             * @var string $code
             * @example "SEC-A"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('sections', 'code')->ignore($sectionId),
            ],

            /**
             * The maximum number of students in the section (optional).
             * @var int|null $max_students
             * @example 30
             */
            'max_students' => [
                'nullable',
                'integer',
                'min:1',
                'max:100'
            ],

            /**
             * The description of the section (optional).
             * @var string|null $description
             * @example "Morning section for computer science"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The status of the section (active/inactive).
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
            // Batch ID
            'batch_id.required' => 'The batch is required.',
            'batch_id.integer' => 'The batch must be a valid integer.',
            'batch_id.exists' => 'The selected batch does not exist.',

            // Name
            'name.required' => 'The section name is required.',
            'name.string' => 'The section name must be a string.',
            'name.max' => 'The section name cannot exceed 255 characters.',
            'name.unique' => 'This section name already exists in this batch.',

            // Code
            'code.required' => 'The section code is required.',
            'code.string' => 'The section code must be a string.',
            'code.max' => 'The section code cannot exceed 50 characters.',
            'code.unique' => 'This section code is already registered.',

            // Max Students
            'max_students.integer' => 'The maximum students must be a valid integer.',
            'max_students.min' => 'The maximum students must be at least 1.',
            'max_students.max' => 'The maximum students cannot exceed 100.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid section status.',

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
            'batch_id' => 'batch',
            'name' => 'section name',
            'code' => 'section code',
            'max_students' => 'maximum students',
            'description' => 'section description',
            'status' => 'section status',
            'sort_order' => 'sort order',
        ];
    }
}
