<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SubjectResource - Version 1
 *
 * Resource for transforming Subject model data into API responses.
 * This resource handles subject data formatting for API endpoints.
 *
 * @package App\Http\Resources\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class SubjectResource extends JsonResource
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
             * The unique identifier of the subject.
             * @var int $id
             * @example 1
             */
            'id' => $this->id,

            /**
             * The name of the subject.
             * @var string $name
             * @example "Introduction to Programming"
             */
            'name' => $this->name,

            /**
             * The unique code of the subject.
             * @var string $code
             * @example "CS101"
             */
            'code' => $this->code,

            /**
             * The credit hours for the subject.
             * @var int $credit_hours
             * @example 3
             */
            'credit_hours' => $this->credit_hours,

            /**
             * The type of the subject.
             * @var string $subject_type
             * @example "compulsory"
             */
            'subject_type' => $this->subject_type,

            /**
             * The class type of the subject.
             * @var string $class_type
             * @example "theory"
             */
            'class_type' => $this->class_type,

            /**
             * The total marks for the subject.
             * @var float|null $total_marks
             * @example 100.00
             */
            'total_marks' => $this->total_marks,

            /**
             * The passing marks for the subject.
             * @var float|null $passing_marks
             * @example 50.00
             */
            'passing_marks' => $this->passing_marks,

            /**
             * The description of the subject.
             * @var string|null $description
             * @example "Introduction to programming concepts"
             */
            'description' => $this->description,

            /**
             * The learning outcomes of the subject.
             * @var string|null $learning_outcomes
             * @example "Students will learn programming fundamentals"
             */
            'learning_outcomes' => $this->learning_outcomes,

            /**
             * The prerequisites for the subject.
             * @var string|null $prerequisites
             * @example "Basic mathematics knowledge"
             */
            'prerequisites' => $this->prerequisites,

            /**
             * The status of the subject.
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
             * The programs associated with this subject (loaded when relationship is included).
             * @var ProgramResource[]|null $programs
             */
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),

            /**
             * The number of programs associated with this subject (computed when programs are loaded).
             * @var int|null $programs_count
             * @example 3
             */
            'programs_count' => $this->whenLoaded('programs', function () {
                return $this->programs->count();
            }),
        ];
    }
}