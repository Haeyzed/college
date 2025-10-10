<?php

namespace App\Enums\v1;

/**
 * Member Type Enum
 *
 * Defines the available member types for book issuing in the system.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum MemberType: string
{
    case STUDENT = 'student';
    case STAFF = 'staff';

    /**
     * Get all member type values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all member type labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get the string representation of the member type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::STUDENT => 'Student',
            self::STAFF => 'Staff',
        };
    }

    /**
     * Get all member type options with labels.
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
}
