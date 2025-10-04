<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Student Leave Resource - Version 1
 *
 * This resource transforms StudentLeave model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentLeaveResource extends JsonResource
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
            'leave_no' => $this->leave_no,
            'leave_type' => $this->leave_type,
            'leave_type_text' => $this->getLeaveTypeText(),
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'total_days' => $this->total_days,
            'reason' => $this->reason,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'applied_date' => $this->applied_date?->format('Y-m-d'),
            'approved_date' => $this->approved_date?->format('Y-m-d'),
            'rejected_date' => $this->rejected_date?->format('Y-m-d'),
            'approved_by' => $this->approved_by,
            'rejected_by' => $this->rejected_by,
            'approval_notes' => $this->approval_notes,
            'rejection_reason' => $this->rejection_reason,
            'attachment' => $this->attachment,
            'is_emergency' => $this->is_emergency,
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
