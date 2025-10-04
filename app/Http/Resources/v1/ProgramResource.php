<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Program Resource - Version 1
 *
 * This resource transforms Program model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ProgramResource extends JsonResource
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
            'shortcode' => $this->shortcode,
            'slug' => $this->slug,
            'description' => $this->description,
            'duration' => $this->duration,
            'duration_type' => $this->duration_type,
            'duration_text' => $this->getDurationText(),
            'total_credits' => $this->total_credits,
            'total_semesters' => $this->total_semesters,
            'fee_structure' => $this->fee_structure,
            'admission_requirements' => $this->admission_requirements,
            'curriculum' => $this->curriculum,
            'career_prospects' => $this->career_prospects,
            'image' => $this->image,
            'brochure' => $this->brochure,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,

            // Faculty Information
            'faculty_info' => [
                'faculty_id' => $this->faculty_id,
                'faculty' => new FacultyResource($this->whenLoaded('faculty')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'batches' => BatchResource::collection($this->whenLoaded('batches')),
                'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
                'sessions' => SessionResource::collection($this->whenLoaded('sessions')),
                'semesters' => SemesterResource::collection($this->whenLoaded('semesters')),
                'students' => StudentResource::collection($this->whenLoaded('students')),
                'applications' => ApplicationResource::collection($this->whenLoaded('applications')),
            ],
        ];
    }
}
