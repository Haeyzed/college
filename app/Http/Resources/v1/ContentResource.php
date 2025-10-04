<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Content Resource - Version 1
 *
 * This resource transforms Content model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ContentResource extends JsonResource
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
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'featured_image' => $this->featured_image,
            'publish_date' => $this->publish_date?->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'view_count' => $this->view_count,
            'sort_order' => $this->sort_order,

            // Type Information
            'type_info' => [
                'type_id' => $this->type_id,
                'type' => new ContentTypeResource($this->whenLoaded('type')),
            ],

            // Program Information
            'program_info' => [
                'program_id' => $this->program_id,
                'program' => new ProgramResource($this->whenLoaded('program')),
            ],

            // Polymorphic Relationship Information
            'contentable_info' => [
                'contentable_type' => $this->contentable_type,
                'contentable_id' => $this->contentable_id,
                'contentable' => $this->when($this->contentable, function () {
                    return match ($this->contentable_type) {
                        'App\Models\v1\Student' => new StudentResource($this->contentable),
                        'App\Models\v1\Program' => new ProgramResource($this->contentable),
                        'App\Models\v1\Notice' => new NoticeResource($this->contentable),
                        default => $this->contentable,
                    };
                }),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],

            // Relationships
            'relationships' => [
                'documents' => DocumentResource::collection($this->whenLoaded('documents')),
            ],
        ];
    }
}
