<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Complain Resource - Version 1
 *
 * This resource transforms Complain model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ComplainResource extends JsonResource
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
            'complain_no' => $this->complain_no,
            'title' => $this->title,
            'description' => $this->description,
            'complain_date' => $this->complain_date?->format('Y-m-d'),
            'complain_time' => $this->complain_time?->format('H:i:s'),
            'complainant_name' => $this->complainant_name,
            'complainant_phone' => $this->complainant_phone,
            'complainant_email' => $this->complainant_email,
            'complainant_address' => $this->complainant_address,
            'complainant_id' => $this->complainant_id,
            'complainant_type' => $this->complainant_type,
            'complainant_type_text' => $this->getComplainantTypeText(),
            'priority' => $this->priority,
            'priority_text' => $this->getPriorityText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'resolution' => $this->resolution,
            'resolution_date' => $this->resolution_date?->format('Y-m-d'),
            'assigned_to' => $this->assigned_to,
            'assigned_date' => $this->assigned_date?->format('Y-m-d'),
            'attachment' => $this->attachment,
            'is_anonymous' => $this->is_anonymous,
            'is_urgent' => $this->is_urgent,
            'sort_order' => $this->sort_order,

            // Type Information
            'type_info' => [
                'type_id' => $this->type_id,
                'type' => new ComplainTypeResource($this->whenLoaded('type')),
            ],

            // Source Information
            'source_info' => [
                'source_id' => $this->source_id,
                'source' => new ComplainSourceResource($this->whenLoaded('source')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'documents' => DocumentResource::collection($this->whenLoaded('documents')),
                'notes' => NoteResource::collection($this->whenLoaded('notes')),
            ],
        ];
    }
}
