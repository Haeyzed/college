<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * AcademicSessionResource - Version 1
 *
 * Resource for transforming AcademicSession model data into API responses.
 * This resource handles academic session data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class AcademicSessionResource extends JsonResource
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
             * The unique identifier of the academic session.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the academic session.
             * @var string $name
             * @example "Academic Year 2024-2025"
             */
            'name' => $this->name,

            /**
             * The unique code of the academic session.
             * @var string $code
             * @example "AY2024"
             */
            'code' => $this->code,

            /**
             * The start date of the academic session.
             * @var string $start_date
             * @example "2024-09-01"
             */
            'start_date' => $this->start_date?->format('Y-m-d'),

            /**
             * The end date of the academic session.
             * @var string $end_date
             * @example "2025-08-31"
             */
            'end_date' => $this->end_date?->format('Y-m-d'),

            /**
             * Whether this is the current academic session.
             * @var bool $is_current
             * @example true
             */
            'is_current' => $this->is_current,

            /**
             * The description of the academic session.
             * @var string|null $description
             * @example "Academic year 2024-2025 session"
             */
            'description' => $this->description,

            /**
             * The status of the academic session.
             * @var string $status
             * @example "active"
             */
            'status' => $this->status,

            /**
             * The sort order for display.
             * @var int $sort_order
             * @example 1
             */
            'sort_order' => $this->sort_order,

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
             * The semesters in this academic session (loaded when relationship is included).
             * @var SemesterResource[]|null $semesters
             */
            'semesters' => SemesterResource::collection($this->whenLoaded('semesters')),

            /**
             * The number of semesters in this academic session (computed when semesters are loaded).
             * @var int|null $semesters_count
             * @example 2
             */
            'semesters_count' => $this->whenLoaded('semesters', function () {
                return $this->semesters->count();
            }),
        ];
    }
}
