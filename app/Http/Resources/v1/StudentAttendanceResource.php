<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Student Attendance Resource - Version 1
 *
 * This resource transforms StudentAttendance model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentAttendanceResource extends JsonResource
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
            'attendance_date' => $this->attendance_date?->format('Y-m-d'),
            'attendance_time' => $this->attendance_time?->format('H:i:s'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_present' => $this->is_present,
            'is_absent' => $this->is_absent,
            'is_late' => $this->is_late,
            'is_excused' => $this->is_excused,
            'reason' => $this->reason,
            'notes' => $this->notes,
            'marked_by' => $this->marked_by,
            'marked_date' => $this->marked_date?->format('Y-m-d H:i:s'),
            'ip_address' => $this->ip_address,
            'device_info' => $this->device_info,
            'location' => $this->location,
            'sort_order' => $this->sort_order,

            // Student Information
            'student_info' => [
                'student_id' => $this->student_id,
                'student' => new StudentResource($this->whenLoaded('student')),
            ],

            // Subject Information
            'subject_info' => [
                'subject_id' => $this->subject_id,
                'subject' => new SubjectResource($this->whenLoaded('subject')),
            ],

            // Program Information
            'program_info' => [
                'program_id' => $this->program_id,
                'program' => new ProgramResource($this->whenLoaded('program')),
            ],

            // Semester Information
            'semester_info' => [
                'semester_id' => $this->semester_id,
                'semester' => new SemesterResource($this->whenLoaded('semester')),
            ],

            // Section Information
            'section_info' => [
                'section_id' => $this->section_id,
                'section' => new SectionResource($this->whenLoaded('section')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
