<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * Faculty Request - Version 1
 *
 * This request class handles validation for creating and updating faculties
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FacultyRequest extends BaseRequest
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
        $facultyId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The name of the faculty.
             * @var string $name
             * @example "Faculty of Engineering"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('faculties', 'name')->ignore($facultyId),
            ],

            /**
             * The unique code of the faculty.
             * @var string $code
             * @example "ENG"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('faculties', 'code')->ignore($facultyId),
            ],

            /**
             * The description of the faculty (optional).
             * @var string|null $description
             * @example "Leading faculty in engineering education"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The name of the dean (optional).
             * @var string|null $dean_name
             * @example "Dr. John Smith"
             */
            'dean_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The email of the dean (optional).
             * @var string|null $dean_email
             * @example "dean@faculty.edu"
             */
            'dean_email' => [
                'nullable',
                'email',
                'max:255'
            ],

            /**
             * The phone number of the dean (optional).
             * @var string|null $dean_phone
             * @example "+1234567890"
             */
            'dean_phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The status of the faculty (active/inactive).
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
            'name.required' => 'The faculty name is required.',
            'name.string' => 'The faculty name must be a string.',
            'name.max' => 'The faculty name cannot exceed 255 characters.',
            'name.unique' => 'This faculty name is already registered.',

            // Code
            'code.required' => 'The faculty code is required.',
            'code.string' => 'The faculty code must be a string.',
            'code.max' => 'The faculty code cannot exceed 50 characters.',
            'code.unique' => 'This faculty code is already registered.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Dean Name
            'dean_name.string' => 'The dean name must be a string.',
            'dean_name.max' => 'The dean name cannot exceed 255 characters.',

            // Dean Email
            'dean_email.email' => 'The dean email must be a valid email address.',
            'dean_email.max' => 'The dean email cannot exceed 255 characters.',

            // Dean Phone
            'dean_phone.string' => 'The dean phone must be a string.',
            'dean_phone.max' => 'The dean phone cannot exceed 20 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid faculty status.',
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
            'name' => 'faculty name',
            'code' => 'faculty code',
            'description' => 'faculty description',
            'dean_name' => 'dean name',
            'dean_email' => 'dean email',
            'dean_phone' => 'dean phone',
            'status' => 'faculty status',
        ];
    }
}
