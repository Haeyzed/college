<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * District Resource - Version 1
 *
 * This resource transforms District model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class DistrictResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'slug' => $this->slug,
            'description' => $this->description,
            'area' => $this->area,
            'population' => $this->population,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,

            // Province Information
            'province_info' => [
                'province_id' => $this->province_id,
                'province' => new ProvinceResource($this->whenLoaded('province')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'students' => StudentResource::collection($this->whenLoaded('students')),
                'applications' => ApplicationResource::collection($this->whenLoaded('applications')),
            ],
        ];
    }
}
