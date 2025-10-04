<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Exam Routine Resource - Version 1
 *
 * This resource transforms ExamRoutine model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ExamRoutineResource extends JsonResource
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
            'exam_date' => $this->exam_date?->format('Y-m-d'),
            'start_time' => $this->start_time?->format('H:i:s'),
            'end_time' => $this->end_time?->format('H:i:s'),
            'duration' => $this->duration,
            'room_number' => $this->room_number,
            'supervisor' => $this->supervisor,
            'assistant_supervisor' => $this->assistant_supervisor,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'notes' => $this->notes,
            'sort_order' => $this->sort_order,

            // Exam Information
            'exam_info' => [
                'exam_id' => $this->exam_id,
                'exam' => new ExamResource($this->whenLoaded('exam')),
            ],

            // Subject Information
            'subject_info' => [
                'subject_id' => $this->subject_id,
                'subject' => new SubjectResource($this->whenLoaded('subject')),
            ],

            // Program Information
            'program_info' => [
                'program_id' => $this->program_id,
                'program' => new ProgramResource($this->whenLoaded('program')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
