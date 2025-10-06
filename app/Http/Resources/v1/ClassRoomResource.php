<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * ClassRoomResource - Version 1
 *
 * Resource for transforming ClassRoom model data into API responses.
 * This resource handles classroom data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ClassRoomResource extends JsonResource
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
             * The unique identifier of the classroom.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the classroom.
             * @var string $name
             * @example "Computer Lab 1"
             */
            'name' => $this->name,

            /**
             * The floor where the classroom is located.
             * @var string|null $floor
             * @example "Ground Floor"
             */
            'floor' => $this->floor,

            /**
             * The capacity of the classroom.
             * @var int $capacity
             * @example 30
             */
            'capacity' => $this->capacity,

            /**
             * The type of the classroom.
             * @var string $room_type
             * @example "classroom"
             */
            'room_type' => $this->room_type,

            /**
             * The description of the classroom.
             * @var string|null $description
             * @example "Modern computer laboratory with latest equipment"
             */
            'description' => $this->description,

            /**
             * The facilities available in the classroom.
             * @var array|null $facilities
             * @example ["Projector", "Whiteboard", "Air Conditioning"]
             */
            'facilities' => $this->facilities,

            /**
             * Whether the classroom is currently available.
             * @var bool $is_available
             * @example true
             */
            'is_available' => $this->is_available,

            /**
             * The status of the classroom.
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
             * The programs associated with this classroom (loaded when relationship is included).
             * @var ProgramResource[]|null $programs
             */
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),

            /**
             * The number of programs associated with this classroom (computed when programs are loaded).
             * @var int|null $programs_count
             * @example 2
             */
            'programs_count' => $this->whenLoaded('programs', function () {
                return $this->programs->count();
            }),
        ];
    }
}
