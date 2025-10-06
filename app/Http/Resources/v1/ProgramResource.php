<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ProgramResource - Version 1
 *
 * Resource for transforming Program model data into API responses.
 * This resource handles program data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ProgramResource extends JsonResource
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
             * The unique identifier of the program.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the program.
             * @var string $name
             * @example "Bachelor of Computer Science"
             */
            'name' => $this->name,

            /**
             * The slug of the program.
             * @var string $slug
             * @example "bachelor-of-computer-science"
             */
            'slug' => $this->slug,

            /**
             * The unique code of the program.
             * @var string $code
             * @example "BCS"
             */
            'code' => $this->code,

            /**
             * The description of the program.
             * @var string|null $description
             * @example "Comprehensive computer science program"
             */
            'description' => $this->description,

            /**
             * The duration of the program in years.
             * @var int $duration_years
             * @example 4
             */
            'duration_years' => $this->duration_years,

            /**
             * The total credits required for the program.
             * @var int $total_credits
             * @example 120
             */
            'total_credits' => $this->total_credits,

            /**
             * The degree type of the program.
             * @var string $degree_type
             * @example "bachelor"
             */
            'degree_type' => $this->degree_type,

            /**
             * The admission requirements for the program.
             * @var string|null $admission_requirements
             * @example "High school diploma or equivalent"
             */
            'admission_requirements' => $this->admission_requirements,

            /**
             * Whether registration is open for the program.
             * @var bool $is_registration_open
             * @example true
             */
            'is_registration_open' => $this->is_registration_open,

            /**
             * The status of the program.
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
             * The faculty information (loaded when relationship is included).
             * @var FacultyResource|null $faculty
             */
            'faculty' => new FacultyResource($this->whenLoaded('faculty')),

            /**
             * The batches associated with this program (loaded when relationship is included).
             * @var BatchResource[]|null $batches
             */
            'batches' => BatchResource::collection($this->whenLoaded('batches')),

            /**
             * The number of batches in this program (computed when batches are loaded).
             * @var int|null $batches_count
             * @example 3
             */
            'batches_count' => $this->whenLoaded('batches', function () {
                return $this->batches->count();
            }),
        ];
    }
}
