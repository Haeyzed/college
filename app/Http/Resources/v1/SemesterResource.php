<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SemesterResource - Version 1
 *
 * Resource for transforming Semester model data into API responses.
 * This resource handles semester data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SemesterResource extends JsonResource
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
             * The unique identifier of the semester.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the semester.
             * @var string $name
             * @example "Fall 2024"
             */
            'name' => $this->name,

            /**
             * The academic year of the semester.
             * @var int $academic_year
             * @example 2024
             */
            'academic_year' => $this->academic_year,

            /**
             * The start date of the semester.
             * @var string $start_date
             * @example "2024-09-01"
             */
            'start_date' => $this->start_date?->format('Y-m-d'),

            /**
             * The end date of the semester.
             * @var string $end_date
             * @example "2024-12-31"
             */
            'end_date' => $this->end_date?->format('Y-m-d'),

            /**
             * Whether this is the current semester.
             * @var bool $is_current
             * @example true
             */
            'is_current' => $this->is_current,

            /**
             * The description of the semester.
             * @var string|null $description
             * @example "Fall semester for academic year 2024"
             */
            'description' => $this->description,

            /**
             * The status of the semester.
             * @var string $status
             * @example "active"
             */
            'status' => $this->status,

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
             * The programs associated with this semester (loaded when relationship is included).
             * @var ProgramResource[]|null $programs
             */
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),

            /**
             * The academic session information (loaded when relationship is included).
             * @var AcademicSessionResource|null $academic_session
             */
            'academic_session' => new AcademicSessionResource($this->whenLoaded('academicSession')),

            /**
             * The subjects in this semester (loaded when relationship is included).
             * @var SubjectResource[]|null $subjects
             */
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),

            /**
             * The number of subjects in this semester (computed when subjects are loaded).
             * @var int|null $subjects_count
             * @example 5
             */
            'subjects_count' => $this->whenLoaded('subjects', function () {
                return $this->subjects->count();
            }),
        ];
    }
}
