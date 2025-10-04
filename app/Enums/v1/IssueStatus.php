<?php

namespace App\Enums\v1;

/**
 * Issue Status Enum
 *
 * Defines the available status values for book issues in the system.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum IssueStatus: string
{
    case ISSUED = 'issued';
    case RETURNED = 'returned';
    case LOST = 'lost';

    /**
     * Get the string representation of the issue status.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::ISSUED => 'Issued',
            self::RETURNED => 'Returned',
            self::LOST => 'Lost',
        };
    }

    /**
     * Get all issue status values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all issue status labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get all issue status options with labels.
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
