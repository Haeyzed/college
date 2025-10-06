<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use Illuminate\Validation\Rule;

/**
 * Academic Session Request - Version 1
 *
 * This request class handles validation for creating and updating academic sessions
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AcademicSessionRequest extends BaseRequest
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
        $sessionId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The name of the academic session.
             * @var string $name
             * @example "Academic Year 2024-2025"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('academic_sessions', 'name')->ignore($sessionId),
            ],

            /**
             * The start date of the academic session.
             * @var string $start_date
             * @example "2024-09-01"
             */
            'start_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date'
            ],

            /**
             * The end date of the academic session.
             * @var string $end_date
             * @example "2025-05-31"
             */
            'end_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
                'after:start_date'
            ],

            /**
             * Whether this is the current academic session.
             * @var bool|null $is_current
             * @example true
             */
            'is_current' => [
                'nullable',
                'boolean'
            ],

            /**
             * The IDs of the programs associated with the session.
             * @var array<int> $programs
             * @example [1, 5, 8]
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
             * The description of the academic session (optional).
             * @var string|null $description
             * @example "Full academic session for the year."
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The status of the academic session (active/inactive).
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
            'name.required' => 'The session name is required.',
            'name.string' => 'The session name must be a string.',
            'name.max' => 'The session name cannot exceed 255 characters.',
            'name.unique' => 'This session name is already registered.',

            // Start Date
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',

            // End Date
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',

            // Is Current
            'is_current.boolean' => 'The current session flag must be true or false.',

            // Programs
            'programs.required' => 'At least one program ID is required for the session.',
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
            'status.enum' => 'The status must be a valid session status.',
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
            'name' => 'session name',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'is_current' => 'current session',
            'programs' => 'programs',
            'programs.*' => 'program ID',
            'description' => 'session description',
            'status' => 'session status',
        ];
    }
}
