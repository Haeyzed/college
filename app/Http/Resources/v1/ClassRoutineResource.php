<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Routine Resource - Version 1
 *
 * This resource transforms ClassRoutine model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ClassRoutineResource extends JsonResource
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
            'day_of_week' => $this->day_of_week,
            'day_name' => $this->getDayName(),
            'start_time' => $this->start_time?->format('H:i:s'),
            'end_time' => $this->end_time?->format('H:i:s'),
            'duration' => $this->duration,
            'class_type' => $this->class_type,
            'class_type_text' => $this->getClassTypeText(),
            'room_number' => $this->room_number,
            'instructor' => $this->instructor,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_active' => $this->is_active,
            'notes' => $this->notes,
            'sort_order' => $this->sort_order,

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

            // Semester Information
            'semester_info' => [
                'semester_id' => $this->semester_id,
                'semester' => new SemesterResource($this->whenLoaded('semester')),
            ],

            // Section Information
            'section_info' => [
                'section_id' => $this->section_id,
                'section' => new SectionResource($this->whenLoaded('section')),
            ],

            // Class Room Information
            'classroom_info' => [
                'classroom_id' => $this->classroom_id,
                'classroom' => new ClassRoomResource($this->whenLoaded('classroom')),
            ],

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
