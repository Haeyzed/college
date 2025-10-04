<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * StudentEnrollResource - Version 1
 *
 * Resource for transforming StudentEnroll model data into API responses.
 * This resource handles student enrollment data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentEnrollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'program_id' => $this->program_id,
            'session_id' => $this->session_id,
            'semester_id' => $this->semester_id,
            'section_id' => $this->section_id,
            'enroll_date' => $this->enroll_date?->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Relationships
            'student' => new StudentResource($this->whenLoaded('student')),
            'program' => new ProgramResource($this->whenLoaded('program')),
            'session' => new SessionResource($this->whenLoaded('session')),
            'semester' => new SemesterResource($this->whenLoaded('semester')),
            'section' => new SectionResource($this->whenLoaded('section')),

            // Computed fields
            'is_active' => $this->status === 'active',
            'enrollment_duration' => $this->enroll_date ? now()->diffInDays($this->enroll_date) : 0,
        ];
    }
}
