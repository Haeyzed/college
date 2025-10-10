<?php

namespace App\Enums\v1;

/**
 * Subject Type Enum - Version 1
 *
 * This enum defines the available subject types
 * in the College Management System.
 *
 * @package App\Enums\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
enum SubjectType: string
{
    case COMPULSORY = 'compulsory';
    case OPTIONAL = 'optional';
    case ELECTIVE = 'elective';

    /**
     * Get all subject type values as an array.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all subject type labels as an array.
     *
     * @return array
     */
    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }

    /**
     * Get the string representation of the subject type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::COMPULSORY => 'Compulsory',
            self::OPTIONAL => 'Optional',
            self::ELECTIVE => 'Elective',
        };
    }

    /**
     * Get all subject type options with labels.
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
     * Check if the subject type is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this === self::COMPULSORY;
    }

    /**
     * Check if the subject type is optional.
     *
     * @return bool
     */
    public function isOptional(): bool
    {
        return in_array($this, [self::OPTIONAL, self::ELECTIVE]);
    }
}
