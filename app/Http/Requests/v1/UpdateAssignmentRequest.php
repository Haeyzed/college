<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Update Assignment Request - Version 1
 *
 * This request class handles validation for updating existing assignments
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class UpdateAssignmentRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'faculty_id' => ['sometimes', 'required', 'integer', 'exists:faculties,id'],
            'program_id' => ['sometimes', 'required', 'integer', 'exists:programs,id'],
            'session_id' => ['sometimes', 'required', 'integer', 'exists:sessions,id'],
            'semester_id' => ['sometimes', 'required', 'integer', 'exists:semesters,id'],
            'section_id' => ['nullable', 'integer', 'exists:sections,id'],
            'subject_id' => ['sometimes', 'required', 'integer', 'exists:subjects,id'],
            'teacher_id' => ['nullable', 'integer', 'exists:users,id'],
            'start_date' => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'end_date' => ['sometimes', 'required', 'date', 'after:start_date'],
            'total_marks' => ['sometimes', 'required', 'numeric', 'min:0'],
            'pass_marks' => ['sometimes', 'required', 'numeric', 'min:0', 'max:total_marks'],
            'status' => ['nullable', 'integer', Rule::in([0, 1])], // 0=Inactive, 1=Active
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
            'title.required' => 'Assignment title is required.',
            'faculty_id.required' => 'Faculty selection is required.',
            'program_id.required' => 'Program selection is required.',
            'session_id.required' => 'Session selection is required.',
            'semester_id.required' => 'Semester selection is required.',
            'subject_id.required' => 'Subject selection is required.',
            'start_date.required' => 'Start date is required.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.required' => 'End date is required.',
            'end_date.after' => 'End date must be after start date.',
            'total_marks.required' => 'Total marks is required.',
            'total_marks.min' => 'Total marks must be at least 0.',
            'pass_marks.required' => 'Pass marks is required.',
            'pass_marks.min' => 'Pass marks must be at least 0.',
            'pass_marks.max' => 'Pass marks cannot exceed total marks.',
            'faculty_id.exists' => 'Selected faculty is invalid.',
            'program_id.exists' => 'Selected program is invalid.',
            'session_id.exists' => 'Selected session is invalid.',
            'semester_id.exists' => 'Selected semester is invalid.',
            'section_id.exists' => 'Selected section is invalid.',
            'subject_id.exists' => 'Selected subject is invalid.',
            'teacher_id.exists' => 'Selected teacher is invalid.',
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
            'title' => 'assignment title',
            'description' => 'assignment description',
            'faculty_id' => 'faculty',
            'program_id' => 'program',
            'session_id' => 'session',
            'semester_id' => 'semester',
            'section_id' => 'section',
            'subject_id' => 'subject',
            'teacher_id' => 'teacher',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'total_marks' => 'total marks',
            'pass_marks' => 'pass marks',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => auth()->id() ?? 1,
        ]);
    }
}
