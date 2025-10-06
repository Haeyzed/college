<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * EnrollSubjectResource - Version 1
 *
 * Resource for transforming EnrollSubject model data into API responses.
 * This resource handles enroll subject data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class EnrollSubjectResource extends JsonResource
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
             * The unique identifier of the enroll subject.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The program information (loaded when relationship is included).
             * @var ProgramResource|null $program
             */
            'program' => new ProgramResource($this->whenLoaded('program')),

            /**
             * The semester information (loaded when relationship is included).
             * @var SemesterResource|null $semester
             */
            'semester' => new SemesterResource($this->whenLoaded('semester')),

            /**
             * The section information (loaded when relationship is included).
             * @var SectionResource|null $section
             */
            'section' => new SectionResource($this->whenLoaded('section')),

            /**
             * The subjects enrolled for this combination (loaded when relationship is included).
             * @var SubjectResource[]|null $subjects
             */
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),

            /**
             * The status of the enroll subject.
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
             * The number of subjects enrolled (computed when subjects are loaded).
             * @var int|null $subjects_count
             * @example 5
             */
            'subjects_count' => $this->whenLoaded('subjects', function () {
                return $this->subjects->count();
            }),
        ];
    }
}