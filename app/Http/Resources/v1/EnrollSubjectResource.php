<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Enroll Subject Resource - Version 1
 *
 * This resource transforms EnrollSubject model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class EnrollSubjectResource extends JsonResource
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
            'enrollment_date' => $this->enrollment_date?->format('Y-m-d'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'is_completed' => $this->is_completed,
            'completion_date' => $this->completion_date?->format('Y-m-d'),
            'grade' => $this->grade,
            'marks_obtained' => $this->marks_obtained,
            'total_marks' => $this->total_marks,
            'credits_earned' => $this->credits_earned,
            'attendance_percentage' => $this->attendance_percentage,
            'is_eligible_for_exam' => $this->is_eligible_for_exam,
            'notes' => $this->notes,
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

            // Session Information
            'session_info' => [
                'session_id' => $this->session_id,
                'session' => new SessionResource($this->whenLoaded('session')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
