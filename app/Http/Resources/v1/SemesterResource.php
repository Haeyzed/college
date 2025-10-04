<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Semester Resource - Version 1
 *
 * This resource transforms Semester model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SemesterResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'duration' => $this->duration,
            'duration_type' => $this->duration_type,
            'duration_text' => $this->getDurationText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'is_current' => $this->is_current,
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'programs' => ProgramResource::collection($this->whenLoaded('programs')),
                'students' => StudentResource::collection($this->whenLoaded('students')),
                'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
                'routines' => ClassRoutineResource::collection($this->whenLoaded('routines')),
            ],
        ];
    }
}
