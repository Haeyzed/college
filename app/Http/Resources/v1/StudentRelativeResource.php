<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Student Relative Resource - Version 1
 *
 * This resource transforms StudentRelative model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentRelativeResource extends JsonResource
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
            'relationship' => $this->relationship,
            'relationship_text' => $this->getRelationshipText(),
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'occupation' => $this->occupation,
            'workplace' => $this->workplace,
            'work_phone' => $this->work_phone,
            'is_emergency_contact' => $this->is_emergency_contact,
            'is_guardian' => $this->is_guardian,
            'is_guarantor' => $this->is_guarantor,
            'photo' => $this->photo,
            'id_proof' => $this->id_proof,
            'id_proof_number' => $this->id_proof_number,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'notes' => $this->notes,
            'sort_order' => $this->sort_order,

            // Student Information
            'student_info' => [
                'student_id' => $this->student_id,
                'student' => new StudentResource($this->whenLoaded('student')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
