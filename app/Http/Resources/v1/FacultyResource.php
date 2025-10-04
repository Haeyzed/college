<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Faculty Resource - Version 1
 *
 * This resource transforms Faculty model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FacultyResource extends JsonResource
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
            'dean_name' => $this->dean_name,
            'dean_email' => $this->dean_email,
            'dean_phone' => $this->dean_phone,
            'office_location' => $this->office_location,
            'website' => $this->website,
            'image' => $this->image,
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
                'programs' => ProgramResource::collection($this->whenLoaded('programs')),
                'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            ],
        ];
    }
}
