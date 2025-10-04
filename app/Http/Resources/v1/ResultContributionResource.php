<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Result Contribution Resource - Version 1
 *
 * This resource transforms ResultContribution model data for API responses
 * in the College Management System.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ResultContributionResource extends JsonResource
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
            'contribution_type' => $this->contribution_type,
            'contribution_type_text' => $this->getContributionTypeText(),
            'marks_obtained' => $this->marks_obtained,
            'total_marks' => $this->total_marks,
            'percentage' => $this->percentage,
            'weight' => $this->weight,
            'weighted_marks' => $this->weighted_marks,
            'grade' => $this->grade,
            'grade_point' => $this->grade_point,
            'status' => $this->status,
            'status_text' => $this->getStatusText(),
            'is_passed' => $this->is_passed,
            'is_improvement' => $this->is_improvement,
            'improvement_attempt' => $this->improvement_attempt,
            'remarks' => $this->remarks,
            'exam_date' => $this->exam_date?->format('Y-m-d'),
            'result_date' => $this->result_date?->format('Y-m-d'),
            'sort_order' => $this->sort_order,

            // Student Information
            'student_info' => [
                'student_id' => $this->student_id,
                'student' => new StudentResource($this->whenLoaded('student')),
            ],

            // Subject Information
            'subject_info' => [
                'subject_id' => $this->subject_id,
                'subject' => new SubjectResource($this->whenLoaded('subject')),
            ],

            // Exam Information
            'exam_info' => [
                'exam_id' => $this->exam_id,
                'exam' => new ExamResource($this->whenLoaded('exam')),
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

            // Timestamps
            'timestamps' => [
                'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            ],
        ];
    }
}


