<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use App\Enums\v1\SubjectType;
use App\Enums\v1\ClassType;
use Illuminate\Validation\Rule;

/**
 * Subject Request - Version 1
 *
 * This request class handles validation for creating and updating subjects
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SubjectRequest extends BaseRequest
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
        $subjectId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The name of the subject.
             * @var string $name
             * @example "Introduction to Programming"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('subjects', 'name')->ignore($subjectId),
            ],

            /**
             * The unique code of the subject.
             * @var string $code
             * @example "CS101"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('subjects', 'code')->ignore($subjectId),
            ],

            /**
             * The credit hours for the subject.
             * @var int $credit_hours
             * @example 3
             */
            'credit_hours' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
                'max:10'
            ],

            /**
             * The type of the subject.
             * @var string $subject_type
             * @example "compulsory"
             */
            'subject_type' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(SubjectType::class)
            ],

            /**
             * The class type of the subject.
             * @var string $class_type
             * @example "theory"
             */
            'class_type' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(ClassType::class)
            ],

            /**
             * The IDs of the programs associated with the subject.
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
                Rule::exists('programs', 'id'),
            ],

            /**
             * The total marks for the subject (optional).
             * @var float|null $total_marks
             * @example 100.00
             */
            'total_marks' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000'
            ],

            /**
             * The passing marks for the subject (optional).
             * @var float|null $passing_marks
             * @example 50.00
             */
            'passing_marks' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000'
            ],

            /**
             * The description of the subject (optional).
             * @var string|null $description
             * @example "Introduction to programming concepts"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The learning outcomes of the subject (optional).
             * @var string|null $learning_outcomes
             * @example "Students will learn programming fundamentals"
             */
            'learning_outcomes' => [
                'nullable',
                'string',
                'max:2000'
            ],

            /**
             * The prerequisites for the subject (optional).
             * @var string|null $prerequisites
             * @example "Basic mathematics knowledge"
             */
            'prerequisites' => [
                'nullable',
                'string',
                'max:500'
            ],

            /**
             * The status of the subject (active/inactive).
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
            'name.required' => 'The subject name is required.',
            'name.string' => 'The subject name must be a string.',
            'name.max' => 'The subject name cannot exceed 255 characters.',
            'name.unique' => 'This subject name is already registered.',

            // Code
            'code.required' => 'The subject code is required.',
            'code.string' => 'The subject code must be a string.',
            'code.max' => 'The subject code cannot exceed 50 characters.',
            'code.unique' => 'This subject code is already registered.',

            // Credit Hours
            'credit_hours.required' => 'The credit hours is required.',
            'credit_hours.integer' => 'The credit hours must be a valid integer.',
            'credit_hours.min' => 'The credit hours must be at least 1.',
            'credit_hours.max' => 'The credit hours cannot exceed 10.',

            // Subject Type
            'subject_type.required' => 'The subject type is required.',
            'subject_type.string' => 'The subject type must be a string.',
            'subject_type.enum' => 'The subject type must be a valid subject type.',

            // Class Type
            'class_type.required' => 'The class type is required.',
            'class_type.string' => 'The class type must be a string.',
            'class_type.enum' => 'The class type must be a valid class type.',

            // Programs
            'programs.required' => 'At least one program ID is required for the subject.',
            'programs.array' => 'The programs field must be an array of program IDs.',
            'programs.min' => 'At least one program must be selected.',
            'programs.*.required' => 'Each program ID in the list is required.',
            'programs.*.integer' => 'Each program ID must be a valid integer.',
            'programs.*.exists' => 'One or more selected program IDs are invalid.',

            // Total Marks
            'total_marks.numeric' => 'The total marks must be a valid number.',
            'total_marks.min' => 'The total marks cannot be negative.',
            'total_marks.max' => 'The total marks cannot exceed 1000.',

            // Passing Marks
            'passing_marks.numeric' => 'The passing marks must be a valid number.',
            'passing_marks.min' => 'The passing marks cannot be negative.',
            'passing_marks.max' => 'The passing marks cannot exceed 1000.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Learning Outcomes
            'learning_outcomes.string' => 'The learning outcomes must be a string.',
            'learning_outcomes.max' => 'The learning outcomes cannot exceed 2000 characters.',

            // Prerequisites
            'prerequisites.string' => 'The prerequisites must be a string.',
            'prerequisites.max' => 'The prerequisites cannot exceed 500 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid subject status.',
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
            'name' => 'subject name',
            'code' => 'subject code',
            'credit_hours' => 'credit hours',
            'subject_type' => 'subject type',
            'class_type' => 'class type',
            'programs' => 'programs',
            'programs.*' => 'program ID',
            'total_marks' => 'total marks',
            'passing_marks' => 'passing marks',
            'description' => 'subject description',
            'learning_outcomes' => 'learning outcomes',
            'prerequisites' => 'prerequisites',
            'status' => 'subject status',
        ];
    }
}
