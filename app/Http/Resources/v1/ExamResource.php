<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Exam Resource - Version 1
 *
 * This resource transforms Exam model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ExamResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'exam_date' => $this->exam_date?->format('Y-m-d'),
            'start_time' => $this->start_time?->format('H:i:s'),
            'end_time' => $this->end_time?->format('H:i:s'),
            'duration' => $this->duration,
            'total_marks' => $this->total_marks,
            'passing_marks' => $this->passing_marks,
            'exam_type' => $this->exam_type,
            'exam_type_text' => $this->getExamTypeText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_published' => $this->is_published,
            'is_completed' => $this->is_completed,
            'instructions' => $this->instructions,
            'room_requirements' => $this->room_requirements,
            'supervisor_requirements' => $this->supervisor_requirements,
            'sort_order' => $this->sort_order,

            // Academic Information
            'academic_info' => [
                'program_id' => $this->program_id,
                'program' => new ProgramResource($this->whenLoaded('program')),
                'subject_id' => $this->subject_id,
                'subject' => new SubjectResource($this->whenLoaded('subject')),
                'semester_id' => $this->semester_id,
                'semester' => new SemesterResource($this->whenLoaded('semester')),
                'session_id' => $this->session_id,
                'session' => new SessionResource($this->whenLoaded('session')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'routines' => ExamRoutineResource::collection($this->whenLoaded('routines')),
                'results' => ResultContributionResource::collection($this->whenLoaded('results')),
            ],
        ];
    }
}
