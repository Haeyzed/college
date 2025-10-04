<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * SubmitAssignmentRequest - Version 1
 *
 * Form request for validating assignment submission data.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SubmitAssignmentRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'submission' => 'required|string',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
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
            'student_id.required' => 'Student is required.',
            'student_id.exists' => 'Selected student does not exist.',
            'submission.required' => 'Submission content is required.',
            'submission.string' => 'Submission must be text.',
            'attach.file' => 'Attachment must be a file.',
            'attach.mimes' => 'Attachment must be a file of type: jpg, jpeg, png, pdf, doc, docx, zip, rar, csv, xls, xlsx, ppt, pptx.',
            'attach.max' => 'Attachment must not be larger than 20MB.',
        ];
    }
}
