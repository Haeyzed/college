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
             * The unique code of the academic session.
             * @var string $code
             * @example "AY2024"
             */
            'code' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                Rule::unique('academic_sessions', 'code')->ignore($sessionId),
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
             * @example "2025-08-31"
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
             * The description of the academic session (optional).
             * @var string|null $description
             * @example "Academic year 2024-2025 session"
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
            // Name
            'name.required' => 'The session name is required.',
            'name.string' => 'The session name must be a string.',
            'name.max' => 'The session name cannot exceed 255 characters.',
            'name.unique' => 'This session name is already registered.',

            // Code
            'code.required' => 'The session code is required.',
            'code.string' => 'The session code must be a string.',
            'code.max' => 'The session code cannot exceed 50 characters.',
            'code.unique' => 'This session code is already registered.',

            // Start Date
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',

            // End Date
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',

            // Is Current
            'is_current.boolean' => 'The current session flag must be true or false.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid session status.',

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
            'name' => 'session name',
            'code' => 'session code',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'is_current' => 'current session',
            'description' => 'session description',
            'status' => 'session status',
            'sort_order' => 'sort order',
        ];
    }
}
