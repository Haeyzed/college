<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BatchResource - Version 1
 *
 * Resource for transforming Batch model data into API responses.
 * This resource handles batch data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class BatchResource extends JsonResource
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
             * The unique identifier of the batch.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the batch.
             * @var string $name
             * @example "Batch 2024"
             */
            'name' => $this->name,

            /**
             * The academic year of the batch.
             * @var int $academic_year
             * @example 2024
             */
            'academic_year' => $this->academic_year,

            /**
             * The start date of the batch.
             * @var string $start_date
             * @example "2024-01-01"
             */
            'start_date' => $this->start_date?->format('Y-m-d'),

            /**
             * The end date of the batch.
             * @var string $end_date
             * @example "2024-12-31"
             */
            'end_date' => $this->end_date?->format('Y-m-d'),

            /**
             * The maximum number of students in the batch.
             * @var int|null $max_students
             * @example 50
             */
            'max_students' => $this->max_students,

            /**
             * The description of the batch.
             * @var string|null $description
             * @example "Computer Science batch for 2024"
             */
            'description' => $this->description,

            /**
             * The status of the batch.
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
             * The programs associated with this batch (loaded when relationship is included).
             * @var ProgramResource[]|null $programs
             */
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),

            /**
             * The sections associated with this batch (loaded when relationship is included).
             * @var SectionResource[]|null $sections
             */
            'sections' => SectionResource::collection($this->whenLoaded('sections')),

            /**
             * The number of sections in this batch (computed when sections are loaded).
             * @var int|null $sections_count
             * @example 3
             */
            'sections_count' => $this->whenLoaded('sections', function () {
                return $this->sections->count();
            }),
        ];
    }
}
