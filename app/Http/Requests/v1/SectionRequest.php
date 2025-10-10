<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
     * @return array<string, ValidationRule|array<mixed>|string>
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
                Rule::unique('sections', 'name')->ignore($sectionId),
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
             * The IDs of the programs associated with the section.
             * @var array<int> $programs
             * @example [1, 5]
             */
            'programs' => [
                $isUpdate ? 'sometimes' : 'required',
                'array',
                'min:1',
            ],
            'programs.*' => [
                'required',
                'integer',
                Rule::exists('programs', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The IDs of the semesters this section is offered in.
             * @var array<int> $semesters
             * @example [1, 2]
             */
            'semesters' => [
                $isUpdate ? 'sometimes' : 'required',
                'array',
                'min:1',
            ],
            'semesters.*' => [
                'required',
                'integer',
                Rule::exists('semesters', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The IDs of the academic items (e.g., subjects/courses) associated with the section.
             * @var array<int> $items
             * @example [101, 102]
             */
            'items' => [
                $isUpdate ? 'sometimes' : 'required',
                'array',
                'min:1',
            ],
            'items.*' => [
                'required',
                'integer',
                Rule::exists('subjects', 'id')->whereNull('deleted_at'),
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
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('programs') && $this->has('semesters') && $this->has('items')) {
                $programs = $this->input('programs', []);
                $semesters = $this->input('semesters', []);
                $items = $this->input('items', []);

                if (count($programs) !== count($semesters) || count($programs) !== count($items)) {
                    $validator->errors()->add('relationships', 'Programs, semesters, and items arrays must have the same length.');
                }
            }
        });
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

            // Max Students
            'seat.integer' => 'The maximum students must be a valid integer.',
            'seat.min' => 'The maximum students must be at least 1.',
            'seat.max' => 'The maximum students cannot exceed 100.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Programs
            'programs.required' => 'At least one program ID is required for the section.',
            'programs.array' => 'The programs field must be an array of program IDs.',
            'programs.min' => 'At least one program must be selected.',
            'programs.*.required' => 'Each program ID in the list is required.',
            'programs.*.integer' => 'Each program ID must be a valid integer.',
            'programs.*.exists' => 'One or more selected program IDs are invalid.',

            // Semesters
            'semesters.required' => 'At least one semester ID is required for the section.',
            'semesters.array' => 'The semesters field must be an array of semester IDs.',
            'semesters.min' => 'At least one semester must be selected.',
            'semesters.*.required' => 'Each semester ID in the list is required.',
            'semesters.*.integer' => 'Each semester ID must be a valid integer.',
            'semesters.*.exists' => 'One or more selected semester IDs are invalid.',

            // Items (New)
            'items.required' => 'At least one item ID is required for the section.',
            'items.array' => 'The items field must be an array of item IDs.',
            'items.min' => 'At least one item must be selected.',
            'items.*.required' => 'Each item ID in the list is required.',
            'items.*.integer' => 'Each item ID must be a valid integer.',
            'items.*.exists' => 'One or more selected item IDs are invalid.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid section status.',
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
            'name' => 'section name',
            'seat' => 'maximum seats',
            'description' => 'section description',
            'programs' => 'programs',
            'programs.*' => 'program ID',
            'semesters' => 'semesters',
            'semesters.*' => 'semester ID',
            'items' => 'items',
            'items.*' => 'item ID',
            'status' => 'section status',
        ];
    }
}
