<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\MemberType;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 * IssueBookRequest - Version 1
 *
 * Request validation for issuing books in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class IssueBookRequest extends BaseRequest
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
        return [
            /**
             * The ID of the member (student) who is borrowing the book.
             * @var int $member_id
             * @example 1
             */
            'member_id' => 'required|integer|exists:users,id',

            /**
             * The type of member borrowing the book (student or staff).
             * @var string $member_type
             * @example "student"
             */
            'member_type' => ['required', 'string', Rule::enum(MemberType::class)],

            /**
             * The due date for returning the book (must be after today).
             * @var string $due_date
             * @example "2024-01-15"
             */
            'due_date' => 'required|date|after:today',
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
            'member_id.required' => 'The member ID is required.',
            'member_id.integer' => 'The member ID must be a valid integer.',
            'member_id.exists' => 'The selected member does not exist.',
            'member_type.required' => 'The member type is required.',
            'member_type.enum' => 'The member type must be a valid member type.',
            'due_date.required' => 'The due date is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after' => 'The due date must be after today.',
        ];
    }
}
