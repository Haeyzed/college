<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Certificate Resource - Version 1
 *
 * This resource transforms Certificate model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class CertificateResource extends JsonResource
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
            'certificate_no' => $this->certificate_no,
            'title' => $this->title,
            'description' => $this->description,
            'certificate_type' => $this->certificate_type,
            'certificate_type_text' => $this->getCertificateTypeText(),
            'issue_date' => $this->issue_date?->format('Y-m-d'),
            'valid_from' => $this->valid_from?->format('Y-m-d'),
            'valid_until' => $this->valid_until?->format('Y-m-d'),
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_verified' => $this->is_verified,
            'verification_date' => $this->verification_date?->format('Y-m-d'),
            'verification_notes' => $this->verification_notes,
            'template_id' => $this->template_id,
            'template' => new CertificateTemplateResource($this->whenLoaded('template')),
            'student_id' => $this->student_id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'program_id' => $this->program_id,
            'program' => new ProgramResource($this->whenLoaded('program')),
            'batch_id' => $this->batch_id,
            'batch' => new BatchResource($this->whenLoaded('batch')),
            'issued_by' => $this->issued_by,
            'issued_date' => $this->issued_date?->format('Y-m-d'),
            'digital_signature' => $this->digital_signature,
            'qr_code' => $this->qr_code,
            'pdf_path' => $this->pdf_path,
            'image_path' => $this->image_path,
            'sort_order' => $this->sort_order,

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
