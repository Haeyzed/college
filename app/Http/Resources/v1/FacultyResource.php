<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * FacultyResource - Version 1
 *
 * Resource for transforming Faculty model data into API responses.
 * This resource handles faculty data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class FacultyResource extends JsonResource
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
             * The unique identifier of the faculty.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the faculty.
             * @var string $name
             * @example "Faculty of Engineering"
             */
            'name' => $this->name,

            /**
             * The unique code of the faculty.
             * @var string $code
             * @example "ENG"
             */
            'code' => $this->code,

            /**
             * The slug of the faculty.
             * @var string $slug
             * @example "faculty-of-engineering"
             */
            'slug' => $this->slug,

            /**
             * The description of the faculty.
             * @var string|null $description
             * @example "Leading faculty in engineering education"
             */
            'description' => $this->description,

            /**
             * The name of the dean.
             * @var string|null $dean_name
             * @example "Dr. John Smith"
             */
            'dean_name' => $this->dean_name,

            /**
             * The email of the dean.
             * @var string|null $dean_email
             * @example "dean@faculty.edu"
             */
            'dean_email' => $this->dean_email,

            /**
             * The phone number of the dean.
             * @var string|null $dean_phone
             * @example "+1234567890"
             */
            'dean_phone' => $this->dean_phone,

            /**
             * The status of the faculty.
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
             * The programs associated with this faculty (loaded when relationship is included).
             * @var ProgramResource[]|null $programs
             */
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),

            /**
             * The number of programs in this faculty (computed when programs are loaded).
             * @var int|null $programs_count
             * @example 5
             */
            'programs_count' => $this->whenLoaded('programs', function () {
                return $this->programs->count();
            }),
        ];
    }
}
