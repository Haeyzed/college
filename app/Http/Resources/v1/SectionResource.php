<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Section Resource - Version 1
 *
 * This resource transforms Section model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SectionResource extends JsonResource
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
            'capacity' => $this->capacity,
            'room_number' => $this->room_number,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'students' => StudentResource::collection($this->whenLoaded('students')),
                'routines' => ClassRoutineResource::collection($this->whenLoaded('routines')),
            ],
        ];
    }
}
