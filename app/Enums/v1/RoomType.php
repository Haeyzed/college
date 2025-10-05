<?php

namespace App\Enums\v1;

/**
 * Room Type Enum - Version 1
 *
 * This enum defines the available room types for classrooms
 * in the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum RoomType: string
{
    case CLASSROOM = 'classroom';
    case LAB = 'lab';
    case LIBRARY = 'library';
    case AUDITORIUM = 'auditorium';
    case CONFERENCE = 'conference';

    /**
     * Get the string representation of the room type.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::CLASSROOM => 'Classroom',
            self::LAB => 'Laboratory',
            self::LIBRARY => 'Library',
            self::AUDITORIUM => 'Auditorium',
            self::CONFERENCE => 'Conference Room',
        };
    }

    /**
     * Get all room type values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all room type labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get all room type options with labels.
     *
     * @return array
     */
    public static function options(): array
    {
        return collect(self::cases())->map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        })->toArray();
    }

    /**
     * Check if the room type is suitable for lectures.
     *
     * @return bool
     */
    public function isSuitableForLectures(): bool
    {
        return in_array($this, [self::CLASSROOM, self::AUDITORIUM]);
    }

    /**
     * Check if the room type is suitable for practical work.
     *
     * @return bool
     */
    public function isSuitableForPractical(): bool
    {
        return in_array($this, [self::LAB, self::CLASSROOM]);
    }

    /**
     * Check if the room type is suitable for large groups.
     *
     * @return bool
     */
    public function isSuitableForLargeGroups(): bool
    {
        return in_array($this, [self::AUDITORIUM, self::LIBRARY]);
    }
}
