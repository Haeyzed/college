<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Student Resource - Version 1
 *
 * This resource transforms Student model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentResource extends JsonResource
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
            'student_id' => $this->student_id,
            'registration_no' => $this->registration_no,
            'admission_date' => $this->admission_date?->format('Y-m-d'),

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
                'blood_group' => $this->blood_group,
                'nationality' => $this->nationality,
                'national_id' => $this->national_id,
                'passport_no' => $this->passport_no,
                'photo' => $this->photo,
                'signature' => $this->signature,
            ],

            // Academic Information
            'academic_info' => [
                'batch_id' => $this->batch_id,
                'batch' => new BatchResource($this->whenLoaded('batch')),
                'program_id' => $this->program_id,
                'program' => new ProgramResource($this->whenLoaded('program')),
                'session_id' => $this->session_id,
                'session' => new SessionResource($this->whenLoaded('session')),
                'semester_id' => $this->semester_id,
                'semester' => new SemesterResource($this->whenLoaded('semester')),
                'section_id' => $this->section_id,
                'section' => new SectionResource($this->whenLoaded('section')),
                'roll_no' => $this->roll_no,
                'academic_year' => $this->academic_year,
                'admission_type' => $this->admission_type,
                'previous_school' => $this->previous_school,
                'previous_qualification' => $this->previous_qualification,
            ],

            // Address Information
            'address_info' => [
                'present_province_id' => $this->present_province_id,
                'present_province' => new ProvinceResource($this->whenLoaded('presentProvince')),
                'present_district_id' => $this->present_district_id,
                'present_district' => new DistrictResource($this->whenLoaded('presentDistrict')),
                'present_village' => $this->present_village,
                'present_address' => $this->present_address,
                'permanent_province_id' => $this->permanent_province_id,
                'permanent_province' => new ProvinceResource($this->whenLoaded('permanentProvince')),
                'permanent_district_id' => $this->permanent_district_id,
                'permanent_district' => new DistrictResource($this->whenLoaded('permanentDistrict')),
                'permanent_village' => $this->permanent_village,
                'permanent_address' => $this->permanent_address,
            ],

            // Status Information
            'status_info' => [
                'status' => $this->status,
                'status_text' => $this->getStatusText(),
                'is_active' => $this->is_active,
                'is_graduated' => $this->is_graduated,
                'graduation_date' => $this->graduation_date?->format('Y-m-d'),
                'withdrawal_date' => $this->withdrawal_date?->format('Y-m-d'),
                'withdrawal_reason' => $this->withdrawal_reason,
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'relatives' => StudentRelativeResource::collection($this->whenLoaded('relatives')),
                'enrollments' => StudentEnrollResource::collection($this->whenLoaded('enrollments')),
                'assignments' => StudentAssignmentResource::collection($this->whenLoaded('assignments')),
                'attendances' => StudentAttendanceResource::collection($this->whenLoaded('attendances')),
                'leaves' => StudentLeaveResource::collection($this->whenLoaded('leaves')),
                'transfers' => StudentTransferResource::collection($this->whenLoaded('transfers')),
                'documents' => DocumentResource::collection($this->whenLoaded('documents')),
                'notes' => NoteResource::collection($this->whenLoaded('notes')),
                'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            ],
        ];
    }
}
