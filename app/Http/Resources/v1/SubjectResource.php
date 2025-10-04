<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Subject Resource - Version 1
 *
 * This resource transforms Subject model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SubjectResource extends JsonResource
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
            'code' => $this->code,
            'slug' => $this->slug,
            'description' => $this->description,
            'credits' => $this->credits,
            'theory_credits' => $this->theory_credits,
            'practical_credits' => $this->practical_credits,
            'total_hours' => $this->total_hours,
            'theory_hours' => $this->theory_hours,
            'practical_hours' => $this->practical_hours,
            'prerequisites' => $this->prerequisites,
            'objectives' => $this->objectives,
            'learning_outcomes' => $this->learning_outcomes,
            'assessment_method' => $this->assessment_method,
            'reference_books' => $this->reference_books,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_elective' => $this->is_elective,
            'is_core' => $this->is_core,
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'programs' => ProgramResource::collection($this->whenLoaded('programs')),
                'enrollments' => EnrollSubjectResource::collection($this->whenLoaded('enrollments')),
                'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
                'exams' => ExamResource::collection($this->whenLoaded('exams')),
                'routines' => ClassRoutineResource::collection($this->whenLoaded('routines')),
            ],
        ];
    }
}
