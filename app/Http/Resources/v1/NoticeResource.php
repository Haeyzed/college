<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Notice Resource - Version 1
 *
 * This resource transforms Notice model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class NoticeResource extends JsonResource
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
            'content' => $this->content,
            'notice_no' => $this->notice_no,
            'publish_date' => $this->publish_date?->format('Y-m-d'),
            'expiry_date' => $this->expiry_date?->format('Y-m-d'),
            'priority' => $this->priority,
            'priority_text' => $this->getPriorityText(),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_featured' => $this->is_featured,
            'is_public' => $this->is_public,
            'is_urgent' => $this->is_urgent,
            'image' => $this->image,
            'attachment' => $this->attachment,
            'sort_order' => $this->sort_order,

            // Category Information
            'category_info' => [
                'category_id' => $this->category_id,
                'category' => new NoticeCategoryResource($this->whenLoaded('category')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'documents' => DocumentResource::collection($this->whenLoaded('documents')),
                'contents' => ContentResource::collection($this->whenLoaded('contents')),
            ],
        ];
    }
}
