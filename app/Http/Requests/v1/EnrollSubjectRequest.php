<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\Status;
use App\Http\Requests\BaseRequest;
use App\Models\v1\EnrollSubject;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * EnrollSubject Request - Version 1
 *
 * This request class handles validation for creating and updating enroll subjects
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class EnrollSubjectRequest extends BaseRequest
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
        $enrollSubjectId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The program ID for the enroll subject.
             * @var int $program_id
             * @example 1
             */
            'program_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                Rule::exists('programs', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The semester ID for the enroll subject.
             * @var int $semester_id
             * @example 1
             */
            'semester_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                Rule::exists('semesters', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The section ID for the enroll subject.
             * @var int $section_id
             * @example 1
             */
            'section_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                Rule::exists('sections', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The subject IDs to enroll for this combination.
             * @var array<int> $subjects
             * @example [1, 2, 3]
             */
            'subjects' => [
                $isUpdate ? 'sometimes' : 'required',
                'array',
                'min:1',
            ],
            'subjects.*' => [
                'required',
                'integer',
                Rule::exists('subjects', 'id')->whereNull('deleted_at'),
            ],

            /**
             * The status of the enroll subject (active/inactive).
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
            if ($this->has('program_id') && $this->has('semester_id') && $this->has('section_id')) {
                $programId = $this->input('program_id');
                $semesterId = $this->input('semester_id');
                $sectionId = $this->input('section_id');
                $enrollSubjectId = $this->route('id');

                // Check for duplicate combination (excluding current record for updates)
                $query = EnrollSubject::query()
                    ->where('program_id', $programId)
                    ->where('semester_id', $semesterId)
                    ->where('section_id', $sectionId);

                if ($enrollSubjectId) {
                    $query->where('id', '!=', $enrollSubjectId);
                }

                if ($query->exists()) {
                    $validator->errors()->add('combination', 'This program, semester, and section combination already exists.');
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
            // Program ID
            'program_id.required' => 'The program ID is required.',
            'program_id.integer' => 'The program ID must be a valid integer.',
            'program_id.exists' => 'The selected program does not exist.',

            // Semester ID
            'semester_id.required' => 'The semester ID is required.',
            'semester_id.integer' => 'The semester ID must be a valid integer.',
            'semester_id.exists' => 'The selected semester does not exist.',

            // Section ID
            'section_id.required' => 'The section ID is required.',
            'section_id.integer' => 'The section ID must be a valid integer.',
            'section_id.exists' => 'The selected section does not exist.',

            // Subjects
            'subjects.required' => 'At least one subject must be selected.',
            'subjects.array' => 'The subjects field must be an array of subject IDs.',
            'subjects.min' => 'At least one subject must be selected.',
            'subjects.*.required' => 'Each subject ID in the list is required.',
            'subjects.*.integer' => 'Each subject ID must be a valid integer.',
            'subjects.*.exists' => 'One or more selected subject IDs are invalid.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid enroll subject status.',

            // Custom validation
            'combination' => 'This program, semester, and section combination already exists.',
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
            'semester_id' => 'semester',
            'section_id' => 'section',
            'subjects' => 'subjects',
            'subjects.*' => 'subject ID',
            'status' => 'enroll subject status',
        ];
    }
}
