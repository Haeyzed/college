<?php

namespace Database\Seeders;

use App\Enums\v1\RoomType;
use App\Enums\v1\Status;
use App\Models\v1\ClassRoom;
use Illuminate\Database\Seeder;

/**
 * ClassRoomSeeder - Version 1
 *
 * Seeds the class_rooms table with realistic classroom data.
 * This seeder creates various types of classrooms with different facilities.
 *
 * @package Database\Seeders
 * @version 1.0.0
 * @author Softmax Technologies
 */
class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = [
            // Regular Classrooms
            [
                'name' => 'Room 101 - Main Building',
                'code' => 'MB-101',
                'floor' => 1,
                'capacity' => 40,
                'room_type' => RoomType::CLASSROOM->value,
                'facilities' => ['Whiteboard', 'Projector', 'Air Conditioning', 'WiFi'],
                'is_available' => true,
                'description' => 'Standard classroom with modern teaching facilities',
                'sort_order' => 1,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Room 102 - Main Building',
                'code' => 'MB-102',
                'floor' => 1,
                'capacity' => 35,
                'room_type' => RoomType::CLASSROOM->value,
                'facilities' => ['Whiteboard', 'Projector', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Standard classroom with basic teaching facilities',
                'sort_order' => 2,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Room 201 - Main Building',
                'code' => 'MB-201',
                'floor' => 2,
                'capacity' => 45,
                'room_type' => RoomType::CLASSROOM->value,
                'facilities' => ['Smart Board', 'Projector', 'Air Conditioning', 'WiFi', 'Sound System'],
                'is_available' => true,
                'description' => 'Advanced classroom with smart board technology',
                'sort_order' => 3,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Room 202 - Main Building',
                'code' => 'MB-202',
                'floor' => 2,
                'capacity' => 30,
                'room_type' => RoomType::CLASSROOM->value,
                'facilities' => ['Whiteboard', 'Projector', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Small classroom for specialized courses',
                'sort_order' => 4,
                'status' => Status::ACTIVE->value,
            ],

            // Computer Labs
            [
                'name' => 'Computer Lab 1 - Technology Building',
                'code' => 'TB-CL1',
                'floor' => 1,
                'capacity' => 30,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['30 Computers', 'Projector', 'Air Conditioning', 'WiFi', 'Printer'],
                'is_available' => true,
                'description' => 'Computer laboratory with modern workstations',
                'sort_order' => 5,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Computer Lab 2 - Technology Building',
                'code' => 'TB-CL2',
                'floor' => 1,
                'capacity' => 25,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['25 Computers', 'Projector', 'Air Conditioning', 'WiFi'],
                'is_available' => true,
                'description' => 'Computer laboratory for programming courses',
                'sort_order' => 6,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Network Lab - Technology Building',
                'code' => 'TB-NL',
                'floor' => 2,
                'capacity' => 20,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Network Equipment', 'Computers', 'Projector', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Specialized laboratory for networking courses',
                'sort_order' => 7,
                'status' => Status::ACTIVE->value,
            ],

            // Science Labs
            [
                'name' => 'Physics Lab 1 - Science Building',
                'code' => 'SB-PL1',
                'floor' => 1,
                'capacity' => 25,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Physics Equipment', 'Workbenches', 'Safety Equipment', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Physics laboratory with modern equipment',
                'sort_order' => 8,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Chemistry Lab 1 - Science Building',
                'code' => 'SB-CL1',
                'floor' => 1,
                'capacity' => 20,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Chemistry Equipment', 'Fume Hoods', 'Safety Equipment', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Chemistry laboratory with safety equipment',
                'sort_order' => 9,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Biology Lab - Science Building',
                'code' => 'SB-BL',
                'floor' => 2,
                'capacity' => 25,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Microscopes', 'Lab Equipment', 'Safety Equipment', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Biology laboratory with microscopes and equipment',
                'sort_order' => 10,
                'status' => Status::ACTIVE->value,
            ],

            // Auditoriums
            [
                'name' => 'Main Auditorium - Central Building',
                'code' => 'CB-AUD',
                'floor' => 1,
                'capacity' => 200,
                'room_type' => RoomType::AUDITORIUM->value,
                'facilities' => ['Stage', 'Sound System', 'Projector', 'Air Conditioning', 'WiFi', 'Lighting'],
                'is_available' => true,
                'description' => 'Main auditorium for large events and lectures',
                'sort_order' => 11,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Small Auditorium - Arts Building',
                'code' => 'AB-AUD',
                'floor' => 1,
                'capacity' => 100,
                'room_type' => RoomType::AUDITORIUM->value,
                'facilities' => ['Stage', 'Sound System', 'Projector', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Small auditorium for presentations and events',
                'sort_order' => 12,
                'status' => Status::ACTIVE->value,
            ],

            // Conference Rooms
            [
                'name' => 'Conference Room 1 - Administration Building',
                'code' => 'AB-CR1',
                'floor' => 2,
                'capacity' => 15,
                'room_type' => RoomType::CONFERENCE->value,
                'facilities' => ['Conference Table', 'Projector', 'Air Conditioning', 'WiFi'],
                'is_available' => true,
                'description' => 'Small conference room for meetings',
                'sort_order' => 13,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Conference Room 2 - Administration Building',
                'code' => 'AB-CR2',
                'floor' => 2,
                'capacity' => 20,
                'room_type' => RoomType::CONFERENCE->value,
                'facilities' => ['Conference Table', 'Smart Board', 'Air Conditioning', 'WiFi'],
                'is_available' => true,
                'description' => 'Large conference room with smart board',
                'sort_order' => 14,
                'status' => Status::ACTIVE->value,
            ],

            // Library Study Rooms
            [
                'name' => 'Study Room 1 - Library',
                'code' => 'LIB-SR1',
                'floor' => 1,
                'capacity' => 8,
                'room_type' => RoomType::LIBRARY->value,
                'facilities' => ['Study Tables', 'WiFi', 'Quiet Environment'],
                'is_available' => true,
                'description' => 'Quiet study room in the library',
                'sort_order' => 15,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Study Room 2 - Library',
                'code' => 'LIB-SR2',
                'floor' => 1,
                'capacity' => 6,
                'room_type' => RoomType::LIBRARY->value,
                'facilities' => ['Study Tables', 'WiFi', 'Quiet Environment'],
                'is_available' => true,
                'description' => 'Small study room for group work',
                'sort_order' => 16,
                'status' => Status::ACTIVE->value,
            ],

            // Engineering Labs
            [
                'name' => 'Mechanical Engineering Lab',
                'code' => 'ENG-ML',
                'floor' => 1,
                'capacity' => 20,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Machinery', 'Tools', 'Safety Equipment', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Mechanical engineering laboratory with machinery',
                'sort_order' => 17,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Electrical Engineering Lab',
                'code' => 'ENG-EL',
                'floor' => 2,
                'capacity' => 25,
                'room_type' => RoomType::LAB->value,
                'facilities' => ['Electrical Equipment', 'Oscilloscopes', 'Safety Equipment', 'Air Conditioning'],
                'is_available' => true,
                'description' => 'Electrical engineering laboratory with testing equipment',
                'sort_order' => 18,
                'status' => Status::ACTIVE->value,
            ],

            // Unavailable Rooms
            [
                'name' => 'Room 103 - Main Building (Under Renovation)',
                'code' => 'MB-103',
                'floor' => 1,
                'capacity' => 30,
                'room_type' => RoomType::CLASSROOM->value,
                'facilities' => ['Under Renovation'],
                'is_available' => false,
                'description' => 'Classroom currently under renovation',
                'sort_order' => 19,
                'status' => Status::INACTIVE->value,
            ],
        ];

        foreach ($classrooms as $classroom) {
            ClassRoom::create($classroom);
        }

        $this->command->info('Created ' . count($classrooms) . ' classrooms successfully!');
    }
}
