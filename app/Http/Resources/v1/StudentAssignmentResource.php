<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * StudentAssignmentResource - Version 1
 *
 * Resource for transforming student assignment data for API responses.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class StudentAssignmentResource extends JsonResource
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
            'assignment_id' => $this->assignment_id,
            'student_id' => $this->student_id,
            'submission' => $this->submission,
            'attach' => $this->attach,
            'marks' => $this->marks,
            'feedback' => $this->feedback,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at?->format('Y-m-d H:i:s'),
            'graded_at' => $this->graded_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Relationships
            'student' => $this->whenLoaded('student', function () {
                return [
                    'id' => $this->student->id,
                    'name' => $this->student->first_name . ' ' . $this->student->last_name,
                    'student_id' => $this->student->student_id,
                ];
            }),
            'assignment' => $this->whenLoaded('assignment', function () {
                return [
                    'id' => $this->assignment->id,
                    'title' => $this->assignment->title,
                    'total_marks' => $this->assignment->total_marks,
                ];
            }),
        ];
    }
}
