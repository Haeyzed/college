<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * GradeAssignmentRequest - Version 1
 *
 * Form request for validating assignment grading data.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class GradeAssignmentRequest extends FormRequest
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
            'marks' => 'required|numeric|min:0',
            'feedback' => 'nullable|string|max:1000',
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
            'marks.required' => 'Marks are required.',
            'marks.numeric' => 'Marks must be a number.',
            'marks.min' => 'Marks must be at least 0.',
            'feedback.string' => 'Feedback must be text.',
            'feedback.max' => 'Feedback must not exceed 1000 characters.',
        ];
    }
}
