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
             * The maximum number of seats in the section (optional).
             * @var int|null $seat
             * @example 30
             */
            'seat' => [
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
            'seat.integer' => 'The maximum students must be a valid integer.',
            'seat.min' => 'The maximum students must be at least 1.',
            'seat.max' => 'The maximum students cannot exceed 100.',

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
            'seat' => 'maximum seats',
            'description' => 'section description',
            'status' => 'section status',
            'sort_order' => 'sort order',
        ];
    }
}
