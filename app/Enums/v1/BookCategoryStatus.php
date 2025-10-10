<?php

namespace App\Enums\v1;

/**
 * Book Category Status Enum
 *
 * Defines the available status values for book categories in the system.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum BookCategoryStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    /**
     * Get all status values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all status labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get the string representation of the status.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    /**
     * Get all status options with labels.
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
