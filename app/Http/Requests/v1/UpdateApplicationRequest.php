<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Update Application Request - Version 1
 *
 * This request class handles validation for updating existing applications
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class UpdateApplicationRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $applicationId = $this->route('id');

        return [
            // Basic Information
            'registration_no' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('applications', 'registration_no')->ignore($applicationId)
            ],
            'batch_id' => ['nullable', 'integer', 'exists:batches,id'],
            'program_id' => ['nullable', 'integer', 'exists:programs,id'],
            'apply_date' => ['nullable', 'date', 'before_or_equal:today'],

            // Personal Information
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'father_occupation' => ['nullable', 'string', 'max:255'],
            'mother_occupation' => ['nullable', 'string', 'max:255'],
            'father_photo' => ['nullable', 'string'],
            'mother_photo' => ['nullable', 'string'],

            // Contact Information
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('applications', 'email')->ignore($applicationId)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],

            // Address Information
            'country' => ['nullable', 'string', 'max:255'],
            'present_province' => ['nullable', 'integer', 'exists:provinces,id'],
            'present_district' => ['nullable', 'integer', 'exists:districts,id'],
            'present_village' => ['nullable', 'string'],
            'present_address' => ['nullable', 'string'],
            'permanent_province' => ['nullable', 'integer', 'exists:provinces,id'],
            'permanent_district' => ['nullable', 'integer', 'exists:districts,id'],
            'permanent_village' => ['nullable', 'string'],
            'permanent_address' => ['nullable', 'string'],

            // Personal Details
            'gender' => ['sometimes', 'required', 'integer', Rule::in([1, 2, 3])], // 1=Male, 2=Female, 3=Other
            'dob' => ['sometimes', 'required', 'date', 'before:today'],
            'religion' => ['nullable', 'string', 'max:255'],
            'caste' => ['nullable', 'string', 'max:255'],
            'mother_tongue' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'integer', Rule::in([1, 2, 3, 4])], // 1=Single, 2=Married, 3=Divorced, 4=Widowed
            'blood_group' => ['nullable', 'integer', Rule::in([1, 2, 3, 4, 5, 6, 7, 8])], // A+, A-, B+, B-, AB+, AB-, O+, O-
            'nationality' => ['nullable', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:255'],
            'passport_no' => ['nullable', 'string', 'max:255'],

            // Education Information - School
            'school_name' => ['nullable', 'string'],
            'school_exam_id' => ['nullable', 'string', 'max:255'],
            'school_graduation_field' => ['nullable', 'string', 'max:255'],
            'school_graduation_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'school_graduation_point' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'school_transcript' => ['nullable', 'string', 'max:255'],
            'school_certificate' => ['nullable', 'string', 'max:255'],

            // Education Information - College
            'collage_name' => ['nullable', 'string'],
            'collage_exam_id' => ['nullable', 'string', 'max:255'],
            'collage_graduation_field' => ['nullable', 'string', 'max:255'],
            'collage_graduation_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'collage_graduation_point' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'collage_transcript' => ['nullable', 'string', 'max:255'],
            'collage_certificate' => ['nullable', 'string', 'max:255'],

            // Documents
            'photo' => ['nullable', 'string'],
            'signature' => ['nullable', 'string'],

            // Payment Information
            'fee_amount' => ['nullable', 'numeric', 'min:0'],
            'pay_status' => ['nullable', 'integer', Rule::in([0, 1, 2])], // 0=Unpaid, 1=Paid, 2=Cancel
            'payment_method' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'integer', Rule::in([0, 1, 2])], // 0=Rejected, 1=Pending, 2=Approve
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
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'gender.required' => 'Gender selection is required.',
            'gender.in' => 'Please select a valid gender option.',
            'dob.required' => 'Date of birth is required.',
            'dob.before' => 'Date of birth must be a past date.',
            'registration_no.unique' => 'This registration number is already taken.',
            'batch_id.exists' => 'Selected batch is invalid.',
            'program_id.exists' => 'Selected program is invalid.',
            'present_province.exists' => 'Selected present province is invalid.',
            'present_district.exists' => 'Selected present district is invalid.',
            'permanent_province.exists' => 'Selected permanent province is invalid.',
            'permanent_district.exists' => 'Selected permanent district is invalid.',
            'school_graduation_year.min' => 'School graduation year must be after 1900.',
            'school_graduation_year.max' => 'School graduation year cannot be in the future.',
            'collage_graduation_year.min' => 'College graduation year must be after 1900.',
            'collage_graduation_year.max' => 'College graduation year cannot be in the future.',
            'school_graduation_point.min' => 'School graduation point must be at least 0.',
            'school_graduation_point.max' => 'School graduation point cannot exceed 5.',
            'collage_graduation_point.min' => 'College graduation point must be at least 0.',
            'collage_graduation_point.max' => 'College graduation point cannot exceed 5.',
            'fee_amount.min' => 'Fee amount must be at least 0.',
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
            'first_name' => 'first name',
            'last_name' => 'last name',
            'father_name' => 'father name',
            'mother_name' => 'mother name',
            'father_occupation' => 'father occupation',
            'mother_occupation' => 'mother occupation',
            'dob' => 'date of birth',
            'present_province' => 'present province',
            'present_district' => 'present district',
            'permanent_province' => 'permanent province',
            'permanent_district' => 'permanent district',
            'school_graduation_year' => 'school graduation year',
            'school_graduation_point' => 'school graduation point',
            'collage_graduation_year' => 'college graduation year',
            'collage_graduation_point' => 'college graduation point',
            'fee_amount' => 'fee amount',
            'pay_status' => 'payment status',
            'payment_method' => 'payment method',
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
