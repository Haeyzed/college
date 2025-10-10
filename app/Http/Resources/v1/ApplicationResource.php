<?php

namespace App\Http\Resources\v1;

use App\Enums\v1\ApplicationStatus;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ApplicationResource - Version 1
 *
 * Resource for transforming Application model data into API responses.
 * This resource handles application data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * The unique identifier of the application.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The registration number of the application.
             * @var string $registration_no
             * @example "REG-2024-001"
             */
            'registration_no' => $this->registration_no,

            /**
             * The batch information (loaded when relationship is included).
             * @var BatchResource|null $batch
             */
            'batch' => new BatchResource($this->whenLoaded('batch')),

            /**
             * The program information (loaded when relationship is included).
             * @var ProgramResource|null $program
             */
            'program' => new ProgramResource($this->whenLoaded('program')),

            /**
             * The application date.
             * @var string|null $apply_date
             * @example "2024-01-15"
             */
            'apply_date' => $this->apply_date?->format('Y-m-d'),

            /**
             * The first name of the applicant.
             * @var string $first_name
             * @example "John"
             */
            'first_name' => $this->first_name,

            /**
             * The last name of the applicant.
             * @var string $last_name
             * @example "Doe"
             */
            'last_name' => $this->last_name,

            /**
             * The full name of the applicant.
             * @var string $full_name
             * @example "John Doe"
             */
            'full_name' => $this->first_name . ' ' . $this->last_name,

            /**
             * The father's name of the applicant.
             * @var string $father_name
             * @example "Robert Doe"
             */
            'father_name' => $this->father_name,

            /**
             * The mother's name of the applicant.
             * @var string $mother_name
             * @example "Jane Doe"
             */
            'mother_name' => $this->mother_name,

            /**
             * The father's occupation.
             * @var string $father_occupation
             * @example "Engineer"
             */
            'father_occupation' => $this->father_occupation,

            /**
             * The mother's occupation.
             * @var string $mother_occupation
             * @example "Teacher"
             */
            'mother_occupation' => $this->mother_occupation,

            /**
             * The path to the father's photo.
             * @var string|null $father_photo
             * @example "applications/father_photo.jpg"
             */
            'father_photo' => $this->father_photo,

            /**
             * The father's photo URL.
             * @var string|null $father_photo_url
             * @example "http://localhost/storage/applications/father_photo.jpg"
             */
            'father_photo_url' => StorageHelper::getConfigurableStorageUrl($this->father_photo, 'filesystems.default'),

            /**
             * The path to the mother's photo.
             * @var string|null $mother_photo
             * @example "applications/mother_photo.jpg"
             */
            'mother_photo' => $this->mother_photo,

            /**
             * The mother's photo URL.
             * @var string|null $mother_photo_url
             * @example "http://localhost/storage/applications/mother_photo.jpg"
             */
            'mother_photo_url' => StorageHelper::getConfigurableStorageUrl($this->mother_photo, 'filesystems.default'),

            /**
             * The country of the applicant.
             * @var string $country
             * @example "United States"
             */
            'country' => $this->country,

            /**
             * The present province information (loaded when relationship is included).
             * @var ProvinceResource|null $present_province
             */
            'present_province' => new ProvinceResource($this->whenLoaded('presentProvince')),

            /**
             * The present district information (loaded when relationship is included).
             * @var DistrictResource|null $present_district
             */
            'present_district' => new DistrictResource($this->whenLoaded('presentDistrict')),

            /**
             * The present village.
             * @var string $present_village
             * @example "Downtown"
             */
            'present_village' => $this->present_village,

            /**
             * The present address.
             * @var string $present_address
             * @example "123 Main Street, Downtown"
             */
            'present_address' => $this->present_address,

            /**
             * The permanent province information (loaded when relationship is included).
             * @var ProvinceResource|null $permanent_province
             */
            'permanent_province' => new ProvinceResource($this->whenLoaded('permanentProvince')),

            /**
             * The permanent district information (loaded when relationship is included).
             * @var DistrictResource|null $permanent_district
             */
            'permanent_district' => new DistrictResource($this->whenLoaded('permanentDistrict')),

            /**
             * The permanent village.
             * @var string $permanent_village
             * @example "Uptown"
             */
            'permanent_village' => $this->permanent_village,

            /**
             * The permanent address.
             * @var string $permanent_address
             * @example "456 Oak Avenue, Uptown"
             */
            'permanent_address' => $this->permanent_address,

            /**
             * The gender of the applicant.
             * @var string $gender
             * @example "Male"
             */
            'gender' => $this->gender,

            /**
             * The date of birth.
             * @var string|null $dob
             * @example "1995-05-15"
             */
            'dob' => $this->dob?->format('Y-m-d'),

            /**
             * The email address of the applicant.
             * @var string $email
             * @example "john.doe@example.com"
             */
            'email' => $this->email,

            /**
             * The phone number of the applicant.
             * @var string $phone
             * @example "+1234567890"
             */
            'phone' => $this->phone,

            /**
             * The emergency phone number.
             * @var string $emergency_phone
             * @example "+1234567891"
             */
            'emergency_phone' => $this->emergency_phone,

            /**
             * The religion of the applicant.
             * @var string $religion
             * @example "Christian"
             */
            'religion' => $this->religion,

            /**
             * The caste of the applicant.
             * @var string $caste
             * @example "General"
             */
            'caste' => $this->caste,

            /**
             * The mother tongue of the applicant.
             * @var string $mother_tongue
             * @example "English"
             */
            'mother_tongue' => $this->mother_tongue,

            /**
             * The marital status of the applicant.
             * @var string $marital_status
             * @example "Single"
             */
            'marital_status' => $this->marital_status,

            /**
             * The blood group of the applicant.
             * @var string $blood_group
             * @example "O+"
             */
            'blood_group' => $this->blood_group,

            /**
             * The nationality of the applicant.
             * @var string $nationality
             * @example "American"
             */
            'nationality' => $this->nationality,

            /**
             * The national ID of the applicant.
             * @var string|null $national_id
             * @example "123456789"
             */
            'national_id' => $this->national_id,

            /**
             * The passport number of the applicant.
             * @var string|null $passport_no
             * @example "P1234567"
             */
            'passport_no' => $this->passport_no,

            /**
             * The school name.
             * @var string $school_name
             * @example "Central High School"
             */
            'school_name' => $this->school_name,

            /**
             * The school exam ID.
             * @var string $school_exam_id
             * @example "SCH-2023-001"
             */
            'school_exam_id' => $this->school_exam_id,

            /**
             * The school graduation field.
             * @var string $school_graduation_field
             * @example "Science"
             */
            'school_graduation_field' => $this->school_graduation_field,

            /**
             * The school graduation year.
             * @var int $school_graduation_year
             * @example 2023
             */
            'school_graduation_year' => $this->school_graduation_year,

            /**
             * The school graduation point.
             * @var float $school_graduation_point
             * @example 3.8
             */
            'school_graduation_point' => $this->school_graduation_point,

            /**
             * The path to the school transcript.
             * @var string|null $school_transcript
             * @example "applications/school_transcript.pdf"
             */
            'school_transcript' => $this->school_transcript,

            /**
             * The school transcript URL.
             * @var string|null $school_transcript_url
             * @example "http://localhost/storage/applications/school_transcript.pdf"
             */
            'school_transcript_url' => StorageHelper::getConfigurableStorageUrl($this->school_transcript, 'filesystems.default'),

            /**
             * The path to the school certificate.
             * @var string|null $school_certificate
             * @example "applications/school_certificate.pdf"
             */
            'school_certificate' => $this->school_certificate,

            /**
             * The school certificate URL.
             * @var string|null $school_certificate_url
             * @example "http://localhost/storage/applications/school_certificate.pdf"
             */
            'school_certificate_url' => StorageHelper::getConfigurableStorageUrl($this->school_certificate, 'filesystems.default'),

            /**
             * The college name.
             * @var string $collage_name
             * @example "State University"
             */
            'collage_name' => $this->collage_name,

            /**
             * The college exam ID.
             * @var string $collage_exam_id
             * @example "COL-2023-001"
             */
            'collage_exam_id' => $this->collage_exam_id,

            /**
             * The college graduation field.
             * @var string $collage_graduation_field
             * @example "Computer Science"
             */
            'collage_graduation_field' => $this->collage_graduation_field,

            /**
             * The college graduation year.
             * @var int $collage_graduation_year
             * @example 2023
             */
            'collage_graduation_year' => $this->collage_graduation_year,

            /**
             * The college graduation point.
             * @var float $collage_graduation_point
             * @example 3.5
             */
            'collage_graduation_point' => $this->collage_graduation_point,

            /**
             * The path to the college transcript.
             * @var string|null $collage_transcript
             * @example "applications/collage_transcript.pdf"
             */
            'collage_transcript' => $this->collage_transcript,

            /**
             * The college transcript URL.
             * @var string|null $collage_transcript_url
             * @example "http://localhost/storage/applications/collage_transcript.pdf"
             */
            'collage_transcript_url' => StorageHelper::getConfigurableStorageUrl($this->collage_transcript, 'filesystems.default'),

            /**
             * The path to the college certificate.
             * @var string|null $collage_certificate
             * @example "applications/collage_certificate.pdf"
             */
            'collage_certificate' => $this->collage_certificate,

            /**
             * The college certificate URL.
             * @var string|null $collage_certificate_url
             * @example "http://localhost/storage/applications/collage_certificate.pdf"
             */
            'collage_certificate_url' => StorageHelper::getConfigurableStorageUrl($this->collage_certificate, 'filesystems.default'),

            /**
             * The path to the applicant's photo.
             * @var string|null $photo
             * @example "applications/photo.jpg"
             */
            'photo' => $this->photo,

            /**
             * The applicant's photo URL.
             * @var string|null $photo_url
             * @example "http://localhost/storage/applications/photo.jpg"
             */
            'photo_url' => StorageHelper::getConfigurableStorageUrl($this->photo, 'filesystems.default'),

            /**
             * Whether the applicant has a photo.
             * @var bool $has_photo
             * @example true
             */
            'has_photo' => !empty($this->photo),

            /**
             * The path to the applicant's signature.
             * @var string|null $signature
             * @example "applications/signature.jpg"
             */
            'signature' => $this->signature,

            /**
             * The applicant's signature URL.
             * @var string|null $signature_url
             * @example "http://localhost/storage/applications/signature.jpg"
             */
            'signature_url' => StorageHelper::getConfigurableStorageUrl($this->signature, 'filesystems.default'),

            /**
             * Whether the applicant has a signature.
             * @var bool $has_signature
             * @example true
             */
            'has_signature' => !empty($this->signature),

            /**
             * The fee amount for the application.
             * @var float $fee_amount
             * @example 100.00
             */
            'fee_amount' => $this->fee_amount,

            /**
             * The payment status.
             * @var string $pay_status
             * @example "paid"
             */
            'pay_status' => $this->pay_status,

            /**
             * The payment method.
             * @var string $payment_method
             * @example "credit_card"
             */
            'payment_method' => $this->payment_method,

            /**
             * The status of the application.
             * @var string $status
             * @example "pending"
             */
            'status' => $this->status,

            /**
             * The status label of the application.
             * @var string $status_label
             * @example "Pending"
             */
            'status_label' => ApplicationStatus::from($this->status)->label(),

            /**
             * The creation timestamp.
             * @var string|null $created_at
             * @example "2024-01-15 10:30:00"
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            /**
             * The last update timestamp.
             * @var string|null $updated_at
             * @example "2024-01-15 15:45:00"
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
