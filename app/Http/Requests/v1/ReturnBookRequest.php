<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\MemberType;
use Illuminate\Validation\Rule;

/**
 * ReturnBookRequest - Version 1
 *
 * Request validation for returning books in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ReturnBookRequest extends BaseRequest
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
        return [
            /**
             * The ID of the member (student) who is returning the book.
             * @var int $member_id
             * @example 1
             */
            'member_id' => 'required|integer|exists:users,id',

            /**
             * The type of member returning the book (student or staff).
             * @var string $member_type
             * @example "student"
             */
            'member_type' => ['required', 'string', Rule::enum(MemberType::class)],
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
        ];
    }
}
