<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * AssignmentResource - Version 1
 *
 * Resource for transforming assignment data for API responses.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AssignmentResource extends JsonResource
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
            'total_marks' => $this->total_marks,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'attach' => $this->attach,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            
            // Relationships
            'faculty' => $this->whenLoaded('faculty', function () {
                return [
                    'id' => $this->faculty->id,
                    'title' => $this->faculty->title,
                ];
            }),
            'program' => $this->whenLoaded('program', function () {
                return [
                    'id' => $this->program->id,
                    'title' => $this->program->title,
                ];
            }),
            'session' => $this->whenLoaded('session', function () {
                return [
                    'id' => $this->session->id,
                    'title' => $this->session->title,
                ];
            }),
            'semester' => $this->whenLoaded('semester', function () {
                return [
                    'id' => $this->semester->id,
                    'title' => $this->semester->title,
                ];
            }),
            'section' => $this->whenLoaded('section', function () {
                return [
                    'id' => $this->section->id,
                    'title' => $this->section->title,
                ];
            }),
            'subject' => $this->whenLoaded('subject', function () {
                return [
                    'id' => $this->subject->id,
                    'title' => $this->subject->title,
                    'code' => $this->subject->code,
                ];
            }),
            'teacher' => $this->whenLoaded('teacher', function () {
                return [
                    'id' => $this->teacher->id,
                    'name' => $this->teacher->first_name . ' ' . $this->teacher->last_name,
                ];
            }),
            'students' => $this->whenLoaded('students', function () {
                return StudentAssignmentResource::collection($this->students);
            }),
        ];
    }
}