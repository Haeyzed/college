<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use App\Enums\v1\DegreeType;
use Illuminate\Validation\Rule;

/**
 * Program Request - Version 1
 *
 * This request class handles validation for creating and updating programs
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ProgramRequest extends BaseRequest
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
        $programId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The faculty ID that the program belongs to.
             * @var int $faculty_id
             * @example 1
             */
            'faculty_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:faculties,id'
            ],

            /**
             * The name of the program.
             * @var string $name
             * @example "Bachelor of Computer Science"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('programs', 'name')->ignore($programId),
            ],

            /**
             * The unique code of the program.
             * @var string $code
             * @example "BCS"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('programs', 'code')->ignore($programId),
            ],

            /**
             * The description of the program (optional).
             * @var string|null $description
             * @example "Comprehensive computer science program"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The duration of the program in years.
             * @var int $duration_years
             * @example 4
             */
            'duration_years' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
                'max:10'
            ],

            /**
             * The total credits required for the program.
             * @var int $total_credits
             * @example 120
             */
            'total_credits' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
                'max:200'
            ],

            /**
             * The degree type of the program.
             * @var string $degree_type
             * @example "bachelor"
             */
            'degree_type' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(DegreeType::class)
            ],

            /**
             * The admission requirements for the program (optional).
             * @var string|null $admission_requirements
             * @example "High school diploma or equivalent"
             */
            'admission_requirements' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * Whether registration is open for the program.
             * @var bool|null $is_registration_open
             * @example true
             */
            'is_registration_open' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the program (active/inactive).
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
            // Faculty ID
            'faculty_id.required' => 'The faculty is required.',
            'faculty_id.integer' => 'The faculty must be a valid integer.',
            'faculty_id.exists' => 'The selected faculty does not exist.',

            // Name
            'name.required' => 'The program name is required.',
            'name.string' => 'The program name must be a string.',
            'name.max' => 'The program name cannot exceed 255 characters.',
            'name.unique' => 'This program name is already registered.',

            // Code
            'code.required' => 'The program code is required.',
            'code.string' => 'The program code must be a string.',
            'code.max' => 'The program code cannot exceed 50 characters.',
            'code.unique' => 'This program code is already registered.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Duration Years
            'duration_years.required' => 'The duration in years is required.',
            'duration_years.integer' => 'The duration must be a valid integer.',
            'duration_years.min' => 'The duration must be at least 1 year.',
            'duration_years.max' => 'The duration cannot exceed 10 years.',

            // Total Credits
            'total_credits.required' => 'The total credits is required.',
            'total_credits.integer' => 'The total credits must be a valid integer.',
            'total_credits.min' => 'The total credits must be at least 1.',
            'total_credits.max' => 'The total credits cannot exceed 200.',

            // Degree Type
            'degree_type.required' => 'The degree type is required.',
            'degree_type.string' => 'The degree type must be a string.',
            'degree_type.enum' => 'The degree type must be a valid degree type.',

            // Admission Requirements
            'admission_requirements.string' => 'The admission requirements must be a string.',
            'admission_requirements.max' => 'The admission requirements cannot exceed 1000 characters.',

            // Registration Status
            'is_registration_open.boolean' => 'The registration status must be true or false.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid program status.',
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
            'faculty_id' => 'faculty',
            'name' => 'program name',
            'code' => 'program code',
            'description' => 'program description',
            'duration_years' => 'duration in years',
            'total_credits' => 'total credits',
            'degree_type' => 'degree type',
            'admission_requirements' => 'admission requirements',
            'is_registration_open' => 'registration status',
            'status' => 'program status',
        ];
    }
}
