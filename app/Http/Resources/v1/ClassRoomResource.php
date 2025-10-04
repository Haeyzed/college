<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Room Resource - Version 1
 *
 * This resource transforms ClassRoom model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ClassRoomResource extends JsonResource
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
            'room_number' => $this->room_number,
            'floor' => $this->floor,
            'capacity' => $this->capacity,
            'room_type' => $this->room_type,
            'room_type_text' => $this->getRoomTypeText(),
            'facilities' => $this->facilities,
            'equipment' => $this->equipment,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_available' => $this->is_available,
            'is_booked' => $this->is_booked,
            'booking_notes' => $this->booking_notes,
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'routines' => ClassRoutineResource::collection($this->whenLoaded('routines')),
                'bookings' => ClassRoutineResource::collection($this->whenLoaded('bookings')),
            ],
        ];
    }
}
