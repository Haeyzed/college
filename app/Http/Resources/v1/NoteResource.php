<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Note Resource - Version 1
 *
 * This resource transforms Note model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class NoteResource extends JsonResource
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
            'content' => $this->content,
            'note_date' => $this->note_date?->format('Y-m-d H:i:s'),
            'priority' => $this->priority,
            'priority_text' => $this->getPriorityText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_private' => $this->is_private,
            'is_important' => $this->is_important,
            'tags' => $this->tags,
            'reminder_date' => $this->reminder_date?->format('Y-m-d H:i:s'),
            'is_reminder_sent' => $this->is_reminder_sent,
            'attachment' => $this->attachment,
            'sort_order' => $this->sort_order,

            // Polymorphic Relationship Information
            'noteable_info' => [
                'noteable_type' => $this->noteable_type,
                'noteable_id' => $this->noteable_id,
                'noteable' => $this->when($this->noteable, function () {
                    return match ($this->noteable_type) {
                        'App\Models\v1\Student' => new StudentResource($this->noteable),
                        'App\Models\v1\Application' => new ApplicationResource($this->noteable),
                        'App\Models\v1\Complain' => new ComplainResource($this->noteable),
                        'App\Models\v1\Enquiry' => new EnquiryResource($this->noteable),
                        default => $this->noteable,
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
