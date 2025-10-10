<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Base Request Class
 *
 * This base request class provides common validation functionality
 * and standardized error response formatting for all API requests.
 *
 * @package App\Http\Requests
 * @version 1.0.0
 * @author Softmax Technologies
 */
abstract class BaseRequest extends FormRequest
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
    abstract public function rules(): array;

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute has already been taken.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'numeric' => 'The :attribute must be a number.',
            'date' => 'The :attribute must be a valid date.',
            'boolean' => 'The :attribute must be true or false.',
            'in' => 'The selected :attribute is invalid.',
            'exists' => 'The selected :attribute is invalid.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'after' => 'The :attribute must be a date after :date.',
            'before' => 'The :attribute must be a date before :date.',
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
            'email' => 'email address',
            'password' => 'password',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'phone' => 'phone number',
            'date_of_birth' => 'date of birth',
            'student_id' => 'student ID',
            'program_id' => 'program',
            'batch_id' => 'batch',
            'faculty_id' => 'faculty',
            'subject_id' => 'subject',
            'category_id' => 'category',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->validationError($validator->errors(), 'Validation failed');

        throw new HttpResponseException($response);
    }
}
