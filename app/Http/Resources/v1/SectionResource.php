<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SectionResource - Version 1
 *
 * Resource for transforming Section model data into API responses.
 * This resource handles section data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SectionResource extends JsonResource
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
            /**
             * The unique identifier of the section.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the section.
             * @var string $name
             * @example "Section A"
             */
            'name' => $this->name,

            /**
             * The maximum number of students/seats in the section.
             * @var int|null $seat
             * @example 30
             */
            'seat' => $this->seat,

            /**
             * The description of the section.
             * @var string|null $description
             * @example "Morning section for computer science"
             */
            'description' => $this->description,

            /**
             * The status of the section.
             * @var string $status
             * @example "active"
             */
            'status' => (string) $this->status,

            /**
             * The creation timestamp.
             * @var string|null $created_at
             * @example "2023-12-01 10:30:00"
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            /**
             * The last update timestamp.
             * @var string|null $updated_at
             * @example "2023-12-01 15:45:00"
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            /**
             * Timestamp when the record was soft deleted. Null if not deleted.
             * @var string|null $deleted_at
             * @example "2024-05-15T10:00:00.000000Z"
             */
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),

            /**
             * The batch information (loaded when relationship is included).
             * @var BatchResource|null $batch
             */
            'batch' => new BatchResource($this->whenLoaded('batch')),

            /**
             * The assignments for this section (loaded when relationship is included).
             * @var AssignmentResource[]|null $assignments
             */
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),

            /**
             * The program semester sections associated with the section (loaded when relationship is included).
             * @var ProgramSemesterSectionResource[]|null $semester_programs
             */
            'semester_programs' => ProgramSemesterSectionResource::collection($this->whenLoaded('semesterPrograms')),

            /**
             * The program semester sections associated with the section (alias) (loaded when relationship is included).
             * @var ProgramSemesterSectionResource[]|null $program_semesters
             */
            'program_semesters' => ProgramSemesterSectionResource::collection($this->whenLoaded('programSemesters')),

            /**
             * The student enrollment records associated with the section (loaded when relationship is included).
             * @var StudentEnrollResource[]|null $student_enrolls
             */
            'student_enrolls' => StudentEnrollResource::collection($this->whenLoaded('studentEnrolls')),

            /**
             * The class routines associated with the section (loaded when relationship is included).
             * @var ClassRoutineResource[]|null $classes
             */
            'classes' => ClassRoutineResource::collection($this->whenLoaded('classes')),

            /**
             * The academic contents uploaded for this section (loaded when relationship is included).
             * @var ContentResource[]|null $contents
             */
            'contents' => ContentResource::collection($this->whenLoaded('contents')),

            /**
             * The students in this section (loaded when relationship is included).
             * @var StudentResource[]|null $students
             */
            'students' => StudentResource::collection($this->whenLoaded('students')),

            /**
             * The number of students in this section (computed when students are loaded).
             * @var int|null $students_count
             * @example 25
             */
            'students_count' => $this->whenLoaded('students', function () {
                return $this->students->count();
            }),
        ];
    }
}
