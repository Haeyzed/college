<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Document Resource - Version 1
 *
 * This resource transforms Document model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class DocumentResource extends JsonResource
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
            'description' => $this->description,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'file_size' => $this->file_size,
            'file_type' => $this->file_type,
            'mime_type' => $this->mime_type,
            'file_extension' => $this->file_extension,
            'upload_date' => $this->upload_date?->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_public' => $this->is_public,
            'download_count' => $this->download_count,
            'last_downloaded' => $this->last_downloaded?->format('Y-m-d H:i:s'),
            'expiry_date' => $this->expiry_date?->format('Y-m-d'),
            'tags' => $this->tags,
            'sort_order' => $this->sort_order,

            // Polymorphic Relationship Information
            'documentable_info' => [
                'documentable_type' => $this->documentable_type,
                'documentable_id' => $this->documentable_id,
                'documentable' => $this->when($this->documentable, function () {
                    return match ($this->documentable_type) {
                        'App\Models\v1\Student' => new StudentResource($this->documentable),
                        'App\Models\v1\Application' => new ApplicationResource($this->documentable),
                        'App\Models\v1\Notice' => new NoticeResource($this->documentable),
                        'App\Models\v1\Content' => new ContentResource($this->documentable),
                        'App\Models\v1\Complain' => new ComplainResource($this->documentable),
                        default => $this->documentable,
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
