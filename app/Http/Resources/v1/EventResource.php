<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Event Resource - Version 1
 *
 * This resource transforms Event model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class EventResource extends JsonResource
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
            'event_date' => $this->event_date?->format('Y-m-d'),
            'event_time' => $this->event_time?->format('H:i:s'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'end_time' => $this->end_time?->format('H:i:s'),
            'location' => $this->location,
            'organizer' => $this->organizer,
            'contact_person' => $this->contact_person,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'image' => $this->image,
            'banner' => $this->banner,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_featured' => $this->is_featured,
            'is_public' => $this->is_public,
            'registration_required' => $this->registration_required,
            'max_participants' => $this->max_participants,
            'registration_deadline' => $this->registration_deadline?->format('Y-m-d'),
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
