<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Hostel Member Resource - Version 1
 *
 * This resource transforms HostelMember model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class HostelMemberResource extends JsonResource
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
            'membership_no' => $this->membership_no,
            'join_date' => $this->join_date?->format('Y-m-d'),
            'leave_date' => $this->leave_date?->format('Y-m-d'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'room_allocation_date' => $this->room_allocation_date?->format('Y-m-d'),
            'room_vacation_date' => $this->room_vacation_date?->format('Y-m-d'),
            'rent_amount' => $this->rent_amount,
            'security_deposit' => $this->security_deposit,
            'deposit_paid' => $this->deposit_paid,
            'deposit_refunded' => $this->deposit_refunded,
            'emergency_contact' => $this->emergency_contact,
            'emergency_phone' => $this->emergency_phone,
            'special_requirements' => $this->special_requirements,
            'medical_conditions' => $this->medical_conditions,
            'allergies' => $this->allergies,
            'notes' => $this->notes,
            'sort_order' => $this->sort_order,

            // Hostel Information
            'hostel_info' => [
                'hostel_id' => $this->hostel_id,
                'hostel' => new HostelResource($this->whenLoaded('hostel')),
            ],

            // Room Information
            'room_info' => [
                'room_id' => $this->room_id,
                'room' => new HostelRoomResource($this->whenLoaded('room')),
            ],

            // Polymorphic Relationship Information
            'memberable_info' => [
                'memberable_type' => $this->memberable_type,
                'memberable_id' => $this->memberable_id,
                'memberable' => $this->when($this->memberable, function () {
                    return match ($this->memberable_type) {
                        'App\Models\v1\Student' => new StudentResource($this->memberable),
                        'App\Models\v1\OutsideUser' => new OutsideUserResource($this->memberable),
                        default => $this->memberable,
                    };
                }),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
