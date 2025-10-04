<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Application Resource - Version 1
 *
 * This resource transforms Application model data for API responses
 * in the College Management System.
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
            'id' => $this->id,
            'registration_no' => $this->registration_no,
            'apply_date' => $this->apply_date?->format('Y-m-d'),

            // Personal Information
            'personal_info' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'full_name' => $this->first_name . ' ' . $this->last_name,
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'father_occupation' => $this->father_occupation,
                'mother_occupation' => $this->mother_occupation,
                'gender' => $this->gender,
                'gender_text' => $this->getGenderText(),
                'dob' => $this->dob?->format('Y-m-d'),
                'age' => $this->dob?->age,
                'email' => $this->email,
                'phone' => $this->phone,
                'emergency_phone' => $this->emergency_phone,
                'religion' => $this->religion,
                'caste' => $this->caste,
                'mother_tongue' => $this->mother_tongue,
                'marital_status' => $this->marital_status,
                'marital_status_text' => $this->getMaritalStatusText(),
                'blood_group' => $this->blood_group,
                'blood_group_text' => $this->getBloodGroupText(),
                'nationality' => $this->nationality,
                'national_id' => $this->national_id,
                'passport_no' => $this->passport_no,
            ],

            // Address Information
            'address_info' => [
                'country' => $this->country,
                'present_address' => [
                    'province_id' => $this->present_province,
                    'province_name' => $this->presentProvince?->name,
                    'district_id' => $this->present_district,
                    'district_name' => $this->presentDistrict?->name,
                    'village' => $this->present_village,
                    'full_address' => $this->present_address,
                ],
                'permanent_address' => [
                    'province_id' => $this->permanent_province,
                    'province_name' => $this->permanentProvince?->name,
                    'district_id' => $this->permanent_district,
                    'district_name' => $this->permanentDistrict?->name,
                    'village' => $this->permanent_village,
                    'full_address' => $this->permanent_address,
                ],
            ],

            // Academic Information
            'academic_info' => [
                'batch_id' => $this->batch_id,
                'batch_title' => $this->batch?->title,
                'program_id' => $this->program_id,
                'program_title' => $this->program?->title,
                'program_code' => $this->program?->shortcode,
                'faculty_id' => $this->program?->faculty_id,
                'faculty_title' => $this->program?->faculty?->title,
                'school_info' => [
                    'name' => $this->school_name,
                    'exam_id' => $this->school_exam_id,
                    'graduation_field' => $this->school_graduation_field,
                    'graduation_year' => $this->school_graduation_year,
                    'graduation_point' => $this->school_graduation_point,
                    'transcript' => $this->school_transcript,
                    'certificate' => $this->school_certificate,
                ],
                'college_info' => [
                    'name' => $this->collage_name,
                    'exam_id' => $this->collage_exam_id,
                    'graduation_field' => $this->collage_graduation_field,
                    'graduation_year' => $this->collage_graduation_year,
                    'graduation_point' => $this->collage_graduation_point,
                    'transcript' => $this->collage_transcript,
                    'certificate' => $this->collage_certificate,
                ],
            ],

            // Documents
            'documents' => [
                'photo' => $this->photo,
                'signature' => $this->signature,
                'father_photo' => $this->father_photo,
                'mother_photo' => $this->mother_photo,
            ],

            // Payment Information
            'payment_info' => [
                'fee_amount' => $this->fee_amount,
                'pay_status' => $this->pay_status,
                'pay_status_text' => $this->getPaymentStatusText(),
                'payment_method' => $this->payment_method,
            ],

            // Status Information
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'status_badge' => $this->getStatusBadge(),

            // Metadata
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'created_at_human' => $this->created_at?->diffForHumans(),
            'updated_at_human' => $this->updated_at?->diffForHumans(),
        ];
    }

    /**
     * Get gender text representation.
     *
     * @return string
     */
    private function getGenderText(): string
    {
        return match ($this->gender) {
            1 => 'Male',
            2 => 'Female',
            3 => 'Other',
            default => 'Unknown',
        };
    }

    /**
     * Get marital status text representation.
     *
     * @return string
     */
    private function getMaritalStatusText(): string
    {
        return match ($this->marital_status) {
            1 => 'Single',
            2 => 'Married',
            3 => 'Divorced',
            4 => 'Widowed',
            default => 'Unknown',
        };
    }

    /**
     * Get blood group text representation.
     *
     * @return string
     */
    private function getBloodGroupText(): string
    {
        return match ($this->blood_group) {
            1 => 'A+',
            2 => 'A-',
            3 => 'B+',
            4 => 'B-',
            5 => 'AB+',
            6 => 'AB-',
            7 => 'O+',
            8 => 'O-',
            default => 'Unknown',
        };
    }

    /**
     * Get payment status text representation.
     *
     * @return string
     */
    private function getPaymentStatusText(): string
    {
        return match ($this->pay_status) {
            0 => 'Unpaid',
            1 => 'Paid',
            2 => 'Cancelled',
            default => 'Unknown',
        };
    }

    /**
     * Get status text representation.
     *
     * @return string
     */
    private function getStatusText(): string
    {
        return match ($this->status) {
            0 => 'Rejected',
            1 => 'Pending',
            2 => 'Approved',
            default => 'Unknown',
        };
    }

    /**
     * Get status badge information.
     *
     * @return array
     */
    private function getStatusBadge(): array
    {
        return match ($this->status) {
            0 => ['color' => 'red', 'text' => 'Rejected'],
            1 => ['color' => 'yellow', 'text' => 'Pending'],
            2 => ['color' => 'green', 'text' => 'Approved'],
            default => ['color' => 'gray', 'text' => 'Unknown'],
        };
    }
}
