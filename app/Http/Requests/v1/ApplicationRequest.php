<?php

namespace App\Http\Requests\v1;

use App\Enums\v1\ApplicationStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

/**
 * Application Request - Version 1
 *
 * This request class handles validation for creating and updating applications
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationRequest extends BaseRequest
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
    public function rules(): array
    {
        $applicationId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The registration number of the application.
             * @var string $registration_no
             * @example "REG-2024-001"
             */
            'registration_no' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:50',
                $isUpdate ? Rule::unique('applications', 'registration_no')->ignore($applicationId) : 'unique:applications,registration_no'
            ],

            /**
             * The batch ID that the application belongs to.
             * @var int $batch_id
             * @example 1
             */
            'batch_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:batches,id'
            ],

            /**
             * The program ID that the application belongs to.
             * @var int $program_id
             * @example 1
             */
            'program_id' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:programs,id'
            ],

            /**
             * The application date.
             * @var string $apply_date
             * @example "2024-01-15"
             */
            'apply_date' => [
                $isUpdate ? 'sometimes' : 'required',
                'date'
            ],

            /**
             * The first name of the applicant.
             * @var string $first_name
             * @example "John"
             */
            'first_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The last name of the applicant.
             * @var string $last_name
             * @example "Doe"
             */
            'last_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The father's name of the applicant.
             * @var string $father_name
             * @example "Robert Doe"
             */
            'father_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The mother's name of the applicant.
             * @var string $mother_name
             * @example "Jane Doe"
             */
            'mother_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The father's occupation.
             * @var string $father_occupation
             * @example "Engineer"
             */
            'father_occupation' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The mother's occupation.
             * @var string $mother_occupation
             * @example "Teacher"
             */
            'mother_occupation' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The father's photo file.
             * @var mixed|null $father_photo
             */
            'father_photo' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /**
             * The mother's photo file.
             * @var mixed|null $mother_photo
             */
            'mother_photo' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /**
             * The country of the applicant.
             * @var string $country
             * @example "United States"
             */
            'country' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The present province ID.
             * @var int $present_province
             * @example 1
             */
            'present_province' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:provinces,id'
            ],

            /**
             * The present district ID.
             * @var int $present_district
             * @example 1
             */
            'present_district' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:districts,id'
            ],

            /**
             * The present village.
             * @var string $present_village
             * @example "Downtown"
             */
            'present_village' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The present address.
             * @var string $present_address
             * @example "123 Main Street, Downtown"
             */
            'present_address' => [
                $isUpdate ? 'sometimes' : 'required',
                'string'
            ],

            /**
             * The permanent province ID.
             * @var int $permanent_province
             * @example 1
             */
            'permanent_province' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:provinces,id'
            ],

            /**
             * The permanent district ID.
             * @var int $permanent_district
             * @example 1
             */
            'permanent_district' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'exists:districts,id'
            ],

            /**
             * The permanent village.
             * @var string $permanent_village
             * @example "Uptown"
             */
            'permanent_village' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The permanent address.
             * @var string $permanent_address
             * @example "456 Oak Avenue, Uptown"
             */
            'permanent_address' => [
                $isUpdate ? 'sometimes' : 'required',
                'string'
            ],

            /**
             * The gender of the applicant.
             * @var string $gender
             * @example "Male"
             */
            'gender' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'in:Male,Female,Other'
            ],

            /**
             * The date of birth.
             * @var string $dob
             * @example "1995-05-15"
             */
            'dob' => [
                $isUpdate ? 'sometimes' : 'required',
                'date',
                'before:today'
            ],

            /**
             * The email address of the applicant.
             * @var string $email
             * @example "john.doe@example.com"
             */
            'email' => [
                $isUpdate ? 'sometimes' : 'required',
                'email',
                'max:255',
                $isUpdate ? Rule::unique('applications', 'email')->ignore($applicationId) : 'unique:applications,email'
            ],

            /**
             * The phone number of the applicant.
             * @var string $phone
             * @example "+1234567890"
             */
            'phone' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:20'
            ],

            /**
             * The emergency phone number.
             * @var string $emergency_phone
             * @example "+1234567891"
             */
            'emergency_phone' => [
                'nullable',
                'string',
                'max:20'
            ],

            /**
             * The religion of the applicant.
             * @var string $religion
             * @example "Christian"
             */
            'religion' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The caste of the applicant.
             * @var string $caste
             * @example "General"
             */
            'caste' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The mother tongue of the applicant.
             * @var string $mother_tongue
             * @example "English"
             */
            'mother_tongue' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The marital status of the applicant.
             * @var string $marital_status
             * @example "Single"
             */
            'marital_status' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The blood group of the applicant.
             * @var string $blood_group
             * @example "O+"
             */
            'blood_group' => [
                'nullable',
                'string',
                'max:10'
            ],

            /**
             * The nationality of the applicant.
             * @var string $nationality
             * @example "American"
             */
            'nationality' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The national ID of the applicant.
             * @var string|null $national_id
             * @example "123456789"
             */
            'national_id' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The passport number of the applicant.
             * @var string|null $passport_no
             * @example "P1234567"
             */
            'passport_no' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The school name.
             * @var string $school_name
             * @example "Central High School"
             */
            'school_name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],

            /**
             * The school exam ID.
             * @var string $school_exam_id
             * @example "SCH-2023-001"
             */
            'school_exam_id' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The school graduation field.
             * @var string $school_graduation_field
             * @example "Science"
             */
            'school_graduation_field' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The school graduation year.
             * @var int $school_graduation_year
             * @example 2023
             */
            'school_graduation_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . date('Y')
            ],

            /**
             * The school graduation point.
             * @var float $school_graduation_point
             * @example 3.8
             */
            'school_graduation_point' => [
                'nullable',
                'numeric',
                'min:0',
                'max:5'
            ],

            /**
             * The school transcript file.
             * @var mixed|null $school_transcript
             */
            'school_transcript' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120'
            ],

            /**
             * The school certificate file.
             * @var mixed|null $school_certificate
             */
            'school_certificate' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120'
            ],

            /**
             * The college name.
             * @var string $collage_name
             * @example "State University"
             */
            'collage_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The college exam ID.
             * @var string $collage_exam_id
             * @example "COL-2023-001"
             */
            'collage_exam_id' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The college graduation field.
             * @var string $collage_graduation_field
             * @example "Computer Science"
             */
            'collage_graduation_field' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The college graduation year.
             * @var int $collage_graduation_year
             * @example 2023
             */
            'collage_graduation_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . date('Y')
            ],

            /**
             * The college graduation point.
             * @var float $collage_graduation_point
             * @example 3.5
             */
            'collage_graduation_point' => [
                'nullable',
                'numeric',
                'min:0',
                'max:5'
            ],

            /**
             * The college transcript file.
             * @var mixed|null $collage_transcript
             */
            'collage_transcript' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120'
            ],

            /**
             * The college certificate file.
             * @var mixed|null $collage_certificate
             */
            'collage_certificate' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120'
            ],

            /**
             * The applicant's photo file.
             * @var mixed|null $photo
             */
            'photo' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /**
             * The applicant's signature file.
             * @var mixed|null $signature
             */
            'signature' => [
                'sometimes',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /**
             * The fee amount for the application.
             * @var float $fee_amount
             * @example 100.00
             */
            'fee_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            /**
             * The payment status.
             * @var string $pay_status
             * @example "paid"
             */
            'pay_status' => [
                'nullable',
                'string',
                'in:paid,unpaid,pending'
            ],

            /**
             * The payment method.
             * @var string $payment_method
             * @example "credit_card"
             */
            'payment_method' => [
                'nullable',
                'string',
                'max:255'
            ],

            /**
             * The status of the application.
             * @var string|null $status
             * @example "pending"
             */
            'status' => [
                'nullable',
                'string',
                Rule::enum(ApplicationStatus::class)
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
            // Registration Number
            'registration_no.required' => 'The registration number is required.',
            'registration_no.string' => 'The registration number must be a string.',
            'registration_no.max' => 'The registration number cannot exceed 50 characters.',
            'registration_no.unique' => 'This registration number is already registered for another application.',

            // Batch ID
            'batch_id.required' => 'The batch is required.',
            'batch_id.integer' => 'The batch must be a valid integer.',
            'batch_id.exists' => 'The selected batch is invalid.',

            // Program ID
            'program_id.required' => 'The program is required.',
            'program_id.integer' => 'The program must be a valid integer.',
            'program_id.exists' => 'The selected program is invalid.',

            // Apply Date
            'apply_date.required' => 'The application date is required.',
            'apply_date.date' => 'The application date must be a valid date.',

            // First Name
            'first_name.required' => 'The first name is required.',
            'first_name.string' => 'The first name must be a string.',
            'first_name.max' => 'The first name cannot exceed 255 characters.',

            // Last Name
            'last_name.required' => 'The last name is required.',
            'last_name.string' => 'The last name must be a string.',
            'last_name.max' => 'The last name cannot exceed 255 characters.',

            // Father Name
            'father_name.required' => 'The father name is required.',
            'father_name.string' => 'The father name must be a string.',
            'father_name.max' => 'The father name cannot exceed 255 characters.',

            // Mother Name
            'mother_name.required' => 'The mother name is required.',
            'mother_name.string' => 'The mother name must be a string.',
            'mother_name.max' => 'The mother name cannot exceed 255 characters.',

            // Country
            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country cannot exceed 255 characters.',

            // Present Province
            'present_province.required' => 'The present province is required.',
            'present_province.integer' => 'The present province must be a valid integer.',
            'present_province.exists' => 'The selected present province is invalid.',

            // Present District
            'present_district.required' => 'The present district is required.',
            'present_district.integer' => 'The present district must be a valid integer.',
            'present_district.exists' => 'The selected present district is invalid.',

            // Present Address
            'present_address.required' => 'The present address is required.',
            'present_address.string' => 'The present address must be a string.',

            // Permanent Province
            'permanent_province.required' => 'The permanent province is required.',
            'permanent_province.integer' => 'The permanent province must be a valid integer.',
            'permanent_province.exists' => 'The selected permanent province is invalid.',

            // Permanent District
            'permanent_district.required' => 'The permanent district is required.',
            'permanent_district.integer' => 'The permanent district must be a valid integer.',
            'permanent_district.exists' => 'The selected permanent district is invalid.',

            // Permanent Address
            'permanent_address.required' => 'The permanent address is required.',
            'permanent_address.string' => 'The permanent address must be a string.',

            // Gender
            'gender.required' => 'The gender is required.',
            'gender.string' => 'The gender must be a string.',
            'gender.in' => 'The gender must be one of: Male, Female, Other.',

            // Date of Birth
            'dob.required' => 'The date of birth is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before' => 'The date of birth must be before today.',

            // Email
            'email.required' => 'The email address is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email cannot exceed 255 characters.',
            'email.unique' => 'This email is already registered for another application.',

            // Phone
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number cannot exceed 20 characters.',

            // School Name
            'school_name.required' => 'The school name is required.',
            'school_name.string' => 'The school name must be a string.',
            'school_name.max' => 'The school name cannot exceed 255 characters.',

            // School Graduation Year
            'school_graduation_year.integer' => 'The school graduation year must be a valid integer.',
            'school_graduation_year.min' => 'The school graduation year must be after 1899.',
            'school_graduation_year.max' => 'The school graduation year cannot be in the future.',

            // School Graduation Point
            'school_graduation_point.numeric' => 'The school graduation point must be a valid number.',
            'school_graduation_point.min' => 'The school graduation point must be at least 0.',
            'school_graduation_point.max' => 'The school graduation point cannot exceed 5.',

            // College Graduation Year
            'collage_graduation_year.integer' => 'The college graduation year must be a valid integer.',
            'collage_graduation_year.min' => 'The college graduation year must be after 1899.',
            'collage_graduation_year.max' => 'The college graduation year cannot be in the future.',

            // College Graduation Point
            'collage_graduation_point.numeric' => 'The college graduation point must be a valid number.',
            'collage_graduation_point.min' => 'The college graduation point must be at least 0.',
            'collage_graduation_point.max' => 'The college graduation point cannot exceed 5.',

            // Photo
            'photo.file' => 'The photo must be a valid file.',
            'photo.mimes' => 'The photo must be a file of type: jpg, jpeg, png, webp.',
            'photo.max' => 'The photo may not be greater than 2MB.',

            // Signature
            'signature.file' => 'The signature must be a valid file.',
            'signature.mimes' => 'The signature must be a file of type: jpg, jpeg, png, webp.',
            'signature.max' => 'The signature may not be greater than 2MB.',

            // Father Photo
            'father_photo.file' => 'The father photo must be a valid file.',
            'father_photo.mimes' => 'The father photo must be a file of type: jpg, jpeg, png, webp.',
            'father_photo.max' => 'The father photo may not be greater than 2MB.',

            // Mother Photo
            'mother_photo.file' => 'The mother photo must be a valid file.',
            'mother_photo.mimes' => 'The mother photo must be a file of type: jpg, jpeg, png, webp.',
            'mother_photo.max' => 'The mother photo may not be greater than 2MB.',

            // School Transcript
            'school_transcript.file' => 'The school transcript must be a valid file.',
            'school_transcript.mimes' => 'The school transcript must be a file of type: pdf, doc, docx, jpg, jpeg, png.',
            'school_transcript.max' => 'The school transcript may not be greater than 5MB.',

            // School Certificate
            'school_certificate.file' => 'The school certificate must be a valid file.',
            'school_certificate.mimes' => 'The school certificate must be a file of type: pdf, doc, docx, jpg, jpeg, png.',
            'school_certificate.max' => 'The school certificate may not be greater than 5MB.',

            // College Transcript
            'collage_transcript.file' => 'The college transcript must be a valid file.',
            'collage_transcript.mimes' => 'The college transcript must be a file of type: pdf, doc, docx, jpg, jpeg, png.',
            'collage_transcript.max' => 'The college transcript may not be greater than 5MB.',

            // College Certificate
            'collage_certificate.file' => 'The college certificate must be a valid file.',
            'collage_certificate.mimes' => 'The college certificate must be a file of type: pdf, doc, docx, jpg, jpeg, png.',
            'collage_certificate.max' => 'The college certificate may not be greater than 5MB.',

            // Fee Amount
            'fee_amount.numeric' => 'The fee amount must be a valid number.',
            'fee_amount.min' => 'The fee amount must be at least 0.',

            // Payment Status
            'pay_status.string' => 'The payment status must be a string.',
            'pay_status.in' => 'The payment status must be one of: paid, unpaid, pending.',

            // Status
            'status.string' => 'The status must be a valid string.',
            'status.enum' => 'The status must be a valid application status.',
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
            'registration_no' => 'registration number',
            'batch_id' => 'batch',
            'program_id' => 'program',
            'apply_date' => 'application date',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'father_name' => 'father name',
            'mother_name' => 'mother name',
            'father_occupation' => 'father occupation',
            'mother_occupation' => 'mother occupation',
            'father_photo' => 'father photo',
            'mother_photo' => 'mother photo',
            'country' => 'country',
            'present_province' => 'present province',
            'present_district' => 'present district',
            'present_village' => 'present village',
            'present_address' => 'present address',
            'permanent_province' => 'permanent province',
            'permanent_district' => 'permanent district',
            'permanent_village' => 'permanent village',
            'permanent_address' => 'permanent address',
            'gender' => 'gender',
            'dob' => 'date of birth',
            'email' => 'email address',
            'phone' => 'phone number',
            'emergency_phone' => 'emergency phone number',
            'religion' => 'religion',
            'caste' => 'caste',
            'mother_tongue' => 'mother tongue',
            'marital_status' => 'marital status',
            'blood_group' => 'blood group',
            'nationality' => 'nationality',
            'national_id' => 'national ID',
            'passport_no' => 'passport number',
            'school_name' => 'school name',
            'school_exam_id' => 'school exam ID',
            'school_graduation_field' => 'school graduation field',
            'school_graduation_year' => 'school graduation year',
            'school_graduation_point' => 'school graduation point',
            'school_transcript' => 'school transcript',
            'school_certificate' => 'school certificate',
            'collage_name' => 'college name',
            'collage_exam_id' => 'college exam ID',
            'collage_graduation_field' => 'college graduation field',
            'collage_graduation_year' => 'college graduation year',
            'collage_graduation_point' => 'college graduation point',
            'collage_transcript' => 'college transcript',
            'collage_certificate' => 'college certificate',
            'photo' => 'photo',
            'signature' => 'signature',
            'fee_amount' => 'fee amount',
            'pay_status' => 'payment status',
            'payment_method' => 'payment method',
            'status' => 'application status',
        ];
    }
}

