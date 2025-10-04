<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Hostel Room Resource - Version 1
 *
 * This resource transforms HostelRoom model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class HostelRoomResource extends JsonResource
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
            'room_no' => $this->room_no,
            'floor' => $this->floor,
            'capacity' => $this->capacity,
            'occupied' => $this->occupied,
            'available' => $this->available,
            'rent_per_month' => $this->rent_per_month,
            'security_deposit' => $this->security_deposit,
            'facilities' => $this->facilities,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_available' => $this->is_available,
            'sort_order' => $this->sort_order,

            // Hostel Information
            'hostel_info' => [
                'hostel_id' => $this->hostel_id,
                'hostel' => new HostelResource($this->whenLoaded('hostel')),
            ],

            // Room Type Information
            'room_type_info' => [
                'room_type_id' => $this->room_type_id,
                'room_type' => new HostelRoomTypeResource($this->whenLoaded('roomType')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'members' => HostelMemberResource::collection($this->whenLoaded('members')),
            ],
        ];
    }
}
