<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * AssignmentRequest - Version 1
 *
 * Form request for validating assignment data.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AssignmentRequest extends FormRequest
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
        $rules = [
            'faculty_id' => 'required|exists:faculties,id',
            'program_id' => 'required|exists:programs,id',
            'session_id' => 'required|exists:academic_sessions,id',
            'semester_id' => 'required|exists:semesters,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'required|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
            'status' => 'nullable|string|in:active,inactive',
        ];

        // For updates, make some fields optional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['faculty_id'] = 'sometimes|required|exists:faculties,id';
            $rules['program_id'] = 'sometimes|required|exists:programs,id';
            $rules['session_id'] = 'sometimes|required|exists:academic_sessions,id';
            $rules['semester_id'] = 'sometimes|required|exists:semesters,id';
            $rules['section_id'] = 'sometimes|required|exists:sections,id';
            $rules['subject_id'] = 'sometimes|required|exists:subjects,id';
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['total_marks'] = 'sometimes|required|numeric|min:0';
            $rules['end_date'] = 'sometimes|required|date|after_or_equal:start_date';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'faculty_id.required' => 'Faculty is required.',
            'faculty_id.exists' => 'Selected faculty does not exist.',
            'program_id.required' => 'Program is required.',
            'program_id.exists' => 'Selected program does not exist.',
            'session_id.required' => 'Academic session is required.',
            'session_id.exists' => 'Selected academic session does not exist.',
            'semester_id.required' => 'Semester is required.',
            'semester_id.exists' => 'Selected semester does not exist.',
            'section_id.required' => 'Section is required.',
            'section_id.exists' => 'Selected section does not exist.',
            'subject_id.required' => 'Subject is required.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'title.required' => 'Assignment title is required.',
            'title.max' => 'Assignment title must not exceed 255 characters.',
            'total_marks.required' => 'Total marks is required.',
            'total_marks.numeric' => 'Total marks must be a number.',
            'total_marks.min' => 'Total marks must be at least 0.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after_or_equal' => 'End date must be on or after start date.',
            'attach.file' => 'Attachment must be a file.',
            'attach.mimes' => 'Attachment must be a file of type: jpg, jpeg, png, pdf, doc, docx, zip, rar, csv, xls, xlsx, ppt, pptx.',
            'attach.max' => 'Attachment must not be larger than 20MB.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }
}
