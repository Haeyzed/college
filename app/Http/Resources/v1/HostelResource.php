<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Hostel Resource - Version 1
 *
 * This resource transforms Hostel model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class HostelResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'warden_name' => $this->warden_name,
            'warden_phone' => $this->warden_phone,
            'warden_email' => $this->warden_email,
            'capacity' => $this->capacity,
            'available_rooms' => $this->available_rooms,
            'occupied_rooms' => $this->occupied_rooms,
            'rent_per_month' => $this->rent_per_month,
            'security_deposit' => $this->security_deposit,
            'rules' => $this->rules,
            'facilities' => $this->facilities,
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
                'rooms' => HostelRoomResource::collection($this->whenLoaded('rooms')),
                'members' => HostelMemberResource::collection($this->whenLoaded('members')),
            ],
        ];
    }
}
