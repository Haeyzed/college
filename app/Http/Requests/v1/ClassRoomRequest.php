<?php

namespace App\Http\Requests\v1;

use App\Http\Requests\BaseRequest;
use App\Enums\v1\Status;
use App\Enums\v1\RoomType;
use Illuminate\Validation\Rule;

/**
 * ClassRoom Request - Version 1
 *
 * This request class handles validation for creating and updating classrooms
 * in the College Management System.
 *
 * @package App\Http\Requests\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ClassRoomRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $classRoomId = $this->route('id');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            /**
             * The name of the classroom.
             * @var string $name
             * @example "Computer Lab 1"
             */
            'name' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('class_rooms', 'name')->ignore($classRoomId),
            ],

            /**
             * The floor where the classroom is located (optional).
             * @var string|null $floor
             * @example "Ground Floor"
             */
            'floor' => [
                'nullable',
                'string',
                'max:50'
            ],

            /**
             * The capacity of the classroom.
             * @var int $capacity
             * @example 30
             */
            'capacity' => [
                $isUpdate ? 'sometimes' : 'required',
                'integer',
                'min:1',
                'max:1000'
            ],

            /**
             * The type of the classroom.
             * @var string $room_type
             * @example "classroom"
             */
            'room_type' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(RoomType::class)
            ],

            /**
             * The IDs of the programs associated with the classroom (optional).
             * @var array<int>|null $programs
             * @example [1, 5]
             */
            'programs' => [
                'nullable', // Allows a classroom to not be associated with any program initially
                'array',
            ],
            'programs.*' => [
                'required',
                'integer',
                // Validates that each ID exists in the 'programs' table
                Rule::exists('programs', 'id'),
            ],

            /**
             * The description of the classroom (optional).
             * @var string|null $description
             * @example "Modern computer laboratory with latest equipment"
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            /**
             * The facilities available in the classroom (optional).
             * @var array|null $facilities
             * @example ["Projector", "Whiteboard", "Air Conditioning"]
             */
            'facilities' => [
                'nullable',
                'array'
            ],

            /**
             * Individual facility items.
             * @var string $facilities.*
             */
            'facilities.*' => [
                'string',
                'max:100'
            ],

            /**
             * Whether the classroom is currently available.
             * @var bool|null $is_available
             * @example true
             */
            'is_available' => [
                'nullable',
                'boolean'
            ],

            /**
             * The status of the classroom (active/inactive).
             * @var string $status
             * @example "active"
             */
            'status' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                Rule::enum(Status::class)
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'The classroom name is required.',
            'name.string' => 'The classroom name must be a string.',
            'name.max' => 'The classroom name cannot exceed 255 characters.',
            'name.unique' => 'This classroom name is already registered.',

            // Floor
            'floor.string' => 'The floor must be a string.',
            'floor.max' => 'The floor cannot exceed 50 characters.',

            // Capacity
            'capacity.required' => 'The capacity is required.',
            'capacity.integer' => 'The capacity must be a valid integer.',
            'capacity.min' => 'The capacity must be at least 1.',
            'capacity.max' => 'The capacity cannot exceed 1000.',

            // Room Type
            'room_type.required' => 'The room type is required.',
            'room_type.string' => 'The room type must be a string.',
            'room_type.enum' => 'The room type must be a valid room type.',

            // Programs
            'programs.array' => 'The programs field must be an array of program IDs.',
            'programs.*.required' => 'Each program ID in the list is required.',
            'programs.*.integer' => 'Each program ID must be a valid integer.',
            'programs.*.exists' => 'One or more selected program IDs are invalid.',

            // Description
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 1000 characters.',

            // Facilities
            'facilities.array' => 'The facilities must be an array.',
            'facilities.*.string' => 'Each facility must be a string.',
            'facilities.*.max' => 'Each facility cannot exceed 100 characters.',

            // Is Available
            'is_available.boolean' => 'The availability status must be true or false.',

            // Status
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.enum' => 'The status must be a valid classroom status.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'classroom name',
            'floor' => 'floor',
            'capacity' => 'capacity',
            'room_type' => 'room type',
            'programs' => 'programs',
            'programs.*' => 'program ID',
            'description' => 'classroom description',
            'facilities' => 'facilities',
            'is_available' => 'availability status',
            'status' => 'classroom status',
        ];
    }
}
